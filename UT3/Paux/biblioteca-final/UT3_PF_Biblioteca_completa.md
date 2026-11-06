# UT3 · PF · Biblioteca completa: formularios, subida de portadas y pruebas unitarias

**Desarrollo Web en Entorno Servidor · 2.º DAW · Curso 2026/2027** Departamento de Informática · IES Ramón Arcas Meca · Lorca · Práctica final de la unidad (práctica de estudio)

# 1. Objetivo

Construye desde cero una aplicación de biblioteca que integre todos los contenidos de la unidad: peticiones GET y POST, validación manual en el servidor, objetos con herencia y encapsulación, un repositorio y servicios con responsabilidades separadas, subida segura de portadas, redirección tras POST (PRG), edición de fichas y pruebas unitarias con PHPUnit.

La práctica es más larga que el examen a propósito. El examen (2 horas, con partes ya hechas) selecciona piezas de lo que aquí construyes completo: si dominas el conjunto, cualquier pieza suelta se resuelve con más margen.

## 1.1 Qué vas a practicar

| **Bloque del temario** | **Dónde aparece** |
| --- | --- |
| Formularios y peticiones: GET, POST, superglobales, controles | Apartados 5, 7 y 9 |
| Normalizar y validar campos | Apartado 6 |
| Responder con valores y errores | Apartados 6, 7 y 9 |
| Clases, servicios y repositorio | Apartados 3, 4 y 6 |
| Alta, edición y PRG | Apartados 7 y 9 |
| Subida segura de archivos y portadas | Apartados 7, 8 y 9 |
| Pruebas unitarias con PHPUnit | Apartado 10 |

## 1.2 Cómo trabajar

**1.** Escribe todos los archivos desde cero. No copies código del temario ni de la práctica P1: puedes consultarlos y usar el anexo A (cheatsheet), pero el código lo escribes tú. En el examen no tendrás el cheatsheet; cuando repitas la práctica (apartado 13.2), intenta prescindir de él.

**2.** Avanza por fases. Cada fase termina con un **punto de control**: no empieces la siguiente hasta cumplirlo.

**3.** Escribe una pieza cada vez (un método, una vista, un test) y ejecútala antes de seguir. Cuando algo falle, lee el mensaje completo antes de cambiar nada.

**4.** Los métodos de los servicios no imprimen HTML. Las vistas generan el HTML, pero no deciden reglas. Los archivos de public leen la petición, coordinan y responden.

**5.** Todo texto que llega a una vista se escapa con la función e() del apartado 5.1. Los importes se calculan en céntimos y solo se convierten a euros al mostrarlos.

## 1.3 Fases y tiempo orientativo

| **Fase** | **Contenido** | **Apartados** | **Tiempo** |
| --- | --- | --- | --- |
| 1 | Proyecto y modelo | 2 y 3 | 45 min |
| 2 | Datos, repositorio y servicio | 4 | 45 min |
| 3 | Catálogo con GET | 5 | 30 min |
| 4 | Validator y servicio de formulario | 6 | 60 min |
| 5 | Alta con POST, portada y PRG | 7 | 75 min |
| 6 | Servir portadas | 8 | 20 min |
| 7 | Edición | 9 | 60 min |
| 8 | Pruebas unitarias | 10 | 100 min |
| 9 | Verificación y repaso | 11, 12 y 13 | 45 min |

# 2. Crear el proyecto

## 2.1 Comprobar el entorno

**1.** En una terminal, ejecuta por separado `php -v`, `php --ini` y `php -m`. Necesitas PHP 8.3 o superior en la terminal (CLI), que es el PHP que usará PHPUnit.

**2.** En la lista de módulos deben aparecer mbstring y fileinfo (los usa tu código) y dom (lo necesita PHPUnit). El PHP del servidor web puede utilizar otra configuración: la que importa para las subidas es la del PHP que arranque `php -S`.

**3.** Para las portadas, revisa también `upload_max_filesize` y `post_max_size` del mismo `php.ini` que usa `php -S` (valores orientativos del temario: 2M y 8M).

## 2.2 Archivos y responsabilidades

**1.** Trabaja en la carpeta `Paux/biblioteca-final` de este workspace (o crea `biblioteca-final` desde cero en otro sitio). No partas del código de P1.

**2.** Usa el prefijo TuNombre\Biblioteca: sustituye TuNombre por tu nombre y apellidos unidos, sin espacios ni tildes (en este workspace: `AdrianRosel\Biblioteca`). Cada carpeta de src tiene su propio subnamespace: Modelo, Repositorio y Servicio.

**3.** Crea los archivos con esta distribución. Puedes añadir métodos auxiliares, pero no cambies los nombres indicados:

```
biblioteca-final/
  composer.json
  phpunit.xml
  datos/libros.php
  public/index.php
  public/libro-crear.php
  public/libro-editar.php
  public/portada.php
  src/Modelo/Libro.php
  src/Modelo/LibroPapel.php
  src/Modelo/LibroDigital.php
  src/Modelo/LibroNoDisponibleException.php
  src/Repositorio/LibroRepository.php
  src/Repositorio/ArrayLibroRepository.php
  src/Servicio/BibliotecaService.php
  src/Servicio/Validator.php
  src/Servicio/LibroFormService.php
  src/Servicio/PortadaService.php
  storage/portadas/        (carpeta vacía, fuera de public)
  tests/                   (una clase de prueba por clase probada)
  vistas/ayudas.php
  vistas/catalogo.php
  vistas/formulario.php
```

| **Archivo o clase** | **Trabajo concreto** |
| --- | --- |
| public/\*.php | Reciben la petición, leen los datos, deciden la respuesta y terminan incluyendo la vista o redirigiendo. |
| Libro y subclases | Conservan el estado y protegen sus invariantes. |
| LibroRepository | Contrato para obtener, guardar y actualizar libros. |
| BibliotecaService | Opera con los objetos: préstamos, filtros, filas y resumen. |
| Validator y LibroFormService | Reglas reutilizables y lectura, normalización y validación de los campos del formulario. |
| PortadaService | Valida la subida, genera el nombre, mueve el archivo y lo retira. |
| vistas | Generan el HTML. |

## 2.3 Configurar Composer y PHPUnit

**1.** Escribe composer.json con una carga automática PSR-4 que asocie el prefijo TuNombre\Biblioteca\ con la carpeta src/.

**2.** Instala PHPUnit como dependencia de desarrollo: `composer require --dev "phpunit/phpunit:^12.5"`. Comprueba que aparece en require-dev. (En esta práctica de estudio el entorno ya trae PHPUnit ≥ 12.5.8 en `require-dev` por el advisory de seguridad de 12.5.0–12.5.7: no bajes de 12.5.8; el constraint `^12.5` del temario sigue cumpliéndose.)

**3.** Añade a composer.json un script llamado test que ejecute phpunit.

**4.** Escribe phpunit.xml junto a composer.json: bootstrap con el autoload de Composer y una suite llamada Biblioteca que recorra la carpeta tests. La estructura está en el anexo A.9.

**5.** Genera el autoload y arranca el servidor. Mantén esa terminal abierta:

```
composer dump-autoload
php -S localhost:8000 -t public
```

> **Punto de control de 2.** composer dump-autoload termina sin errores, php -S arranca y http://localhost:8000/index.php responde 404 (aún no existe el archivo). `composer test` ejecuta PHPUnit sin error de configuración (puede no encontrar pruebas todavía).

# 3. Diseñar el modelo

## 3.1 Estado común y constructor

Crea Libro como clase abstracta en src/Modelo. Todos los libros comparten estos datos; el tipo lo aporta la subclase y no se almacena.

| **Propiedad y tipo** | **Condición del objeto** |
| --- | --- |
| titulo y autor · string | Textos recortados y no vacíos; título de hasta 120 caracteres y autor de hasta 100, contados en caracteres y no en bytes. |
| paginas · int | Entre 1 y 3000, ambos incluidos. |
| genero · string | ciencia, fantasia o terror. |
| unidades · int | Entre 1 y 50. Ejemplares en papel o licencias digitales. |
| fechaAlta · ?DateTimeImmutable | null representa que no se ha indicado. |
| destacado · bool | Indica si el libro aparece entre los destacados. |
| observaciones · string | Texto recortado de hasta 300 caracteres; puede estar vacío. |
| disponible · bool | Empieza en true. No se recibe en el constructor. |
| portada · ?string | Empieza en null. Guarda el nombre generado del archivo. No se recibe en el constructor. |

**1.** Declara todas las propiedades private; constructor y métodos public. Indica los tipos de retorno de todos los métodos.

**2.** El constructor recibe, en este orden: titulo, autor, paginas, genero, unidades, fechaAlta (por defecto null), destacado (por defecto false) y observaciones (por defecto cadena vacía).

**3.** Escribe una sola vez la lógica que normaliza los textos y comprueba las condiciones. La reutilizan el constructor y actualizarDatos (apartado 3.2). Lanza InvalidArgumentException cuando se incumplan; una llamada desde código también debe proteger el estado. Valida todo antes de asignar nada.

**4.** Importa DateTimeImmutable e InvalidArgumentException desde el espacio global. No guardes textos escapados para HTML.

**5.** Getters sin prefijo get, como en el temario: titulo(), autor(), paginas(), genero(), unidades(), fechaAlta(), destacado(), observaciones(), estaDisponible() y portada().

## 3.2 Operaciones del libro

| **Método** | **Comportamiento** |
| --- | --- |
| prestar(): void | Marca el libro como no disponible. Si ya lo estaba, lanza LibroNoDisponibleException. |
| devolver(): void | Marca el libro como disponible. Si no estaba prestado, lanza LogicException. |
| cambiarPortada(?string $nombre): void | Acepta null (retirar la portada) o un nombre con la forma de un archivo generado: 32 caracteres hexadecimales en minúscula, un punto y jpg, png o webp. Cualquier otro texto lanza InvalidArgumentException. |
| actualizarDatos(...): void | Recibe titulo, autor, paginas, genero, unidades, fechaAlta, destacado y observaciones. Valida todo antes de asignar. No modifica disponibilidad ni portada. |

LibroNoDisponibleException vive en src/Modelo y extiende RuntimeException.

## 3.3 Dos comportamientos mediante herencia

```
abstract public function tipo(): string;
abstract public function costeReposicionCentimos(): int;
```

LibroPapel (final) devuelve papel y calcula paginas × 5 × unidades, en céntimos. LibroDigital (final) devuelve digital y calcula 400 × unidades. Las subclases acceden al estado mediante los getters y no redefinen el constructor.

> **Punto de control de 3.** Crea un script temporal prueba.php en la raíz del proyecto y ejecútalo con `php prueba.php` (lo borrarás en la fase 8). Comprueba: un LibroPapel de Dune (412 páginas, 2 unidades) cuesta 4120 céntimos; un LibroDigital de Solaris (3 unidades) cuesta 1200; construir con 0 páginas lanza excepción; prestar dos veces lanza LibroNoDisponibleException; actualizarDatos con páginas incorrectas lanza excepción y deja el título sin cambiar.

# 4. Preparar los datos, el repositorio y el servicio

## 4.1 Datos iniciales

En datos/libros.php construye los seis objetos siguientes y devuelve un array, respetando el orden. Fecha null y observaciones vacías en todos; destacados únicamente Dune y Drácula. Ninguno tiene portada.

| **Tipo** | **Título** | **Autor** | **Pág.** | **Género** | **Ud.** |
| --- | --- | --- | --- | --- | --- |
| papel | Dune | Frank Herbert | 412 | ciencia | 2 |
| digital | Solaris | Stanislaw Lem | 240 | ciencia | 3 |
| papel | El hobbit | J. R. R. Tolkien | 310 | fantasia | 1 |
| digital | Drácula | Bram Stoker | 418 | terror | 2 |
| papel | Frankenstein | Mary Shelley | 280 | terror | 2 |
| digital | Terramar | Ursula K. Le Guin | 200 | fantasia | 1 |

## 4.2 Repositorio

Declara en src/Repositorio la interfaz LibroRepository con este contrato:

```
public function todos(): array;
public function buscarPorId(int $id): ?Libro;
public function guardar(Libro $libro): int;
public function actualizar(int $id, Libro $libro): void;
```

**1.** ArrayLibroRepository implementa la interfaz con un array privado cuyas claves son los ID. Su constructor recibe un array de libros (vacío por defecto) y les asigna los ID 1, 2, 3… en orden.

**2.** todos devuelve el array completo, con los ID como claves. buscarPorId devuelve el objeto o null si el ID no existe.

**3.** guardar asigna un ID nuevo (el siguiente al último existente; el primero de un repositorio vacío es 1) y lo devuelve.

**4.** actualizar sustituye el objeto de ese ID y conserva el ID. Si el ID no existe, lanza OutOfBoundsException.

**5.** Este array pertenece a una ejecución: no es almacenamiento entre peticiones. Cada petición reconstruye el repositorio desde datos/libros.php.

## 4.3 Contrato de BibliotecaService

En src/Servicio, con el constructor recibiendo un LibroRepository (la interfaz, no la clase concreta):

```
public function __construct(private LibroRepository $repo)
public function prestar(int $id): void
public function devolver(int $id): void
public function filtrar(string $q, string $genero, string $tipo,
    bool $soloDestacados): array
public function filas(array $libros): array
public function resumen(array $libros): array
```

**1.** prestar y devolver localizan el libro por ID y delegan en el objeto. Si el ID no existe, lanzan OutOfBoundsException con el mensaje Libro no encontrado.

**2.** filtrar parte de todos los libros del repositorio, utiliza array_filter y combina los filtros activos con AND. Texto, género y tipo vacíos significan que no se aplica ese filtro. q busca un fragmento del título o del autor sin distinguir mayúsculas de minúsculas (no se exige ignorar tildes). Género y tipo coinciden de forma exacta. Si soloDestacados es true, conserva solo los destacados.

**3.** filtrar conserva los ID como claves: aquí no uses array_values, porque la vista necesita el ID para enlazar a la edición.

**4.** filas utiliza array_map con dos arrays (los libros y sus claves) y devuelve una lista de arrays con las claves id, titulo, autor, paginas, genero, tipo, unidades, fechaAlta, destacado, observaciones, disponible, portada y costeCentimos. La fecha se convierte a Y-m-d o Sin fecha.

**5.** resumen utiliza una sola llamada a array_reduce. Inicializa a 0 las claves titulos (número de objetos, aunque cada uno tenga varias unidades), unidades (suma de unidades), paginas (suma de páginas, una vez por libro) y costeCentimos (suma de costeReposicionCentimos, que ya incluye las unidades).

**6.** Con una colección vacía, filas devuelve [] y resumen devuelve las cuatro claves con valor 0. Ningún método imprime HTML.

> **Punto de control de 4.** Con prueba.php: el repositorio inicial devuelve 6 libros con los ID 1 a 6; filtrar sin filtros da 6 y su resumen 6 títulos, 11 unidades, 1860 páginas y 10870 céntimos; q=lem devuelve solo Solaris (clave 2); genero=terror devuelve Drácula y Frankenstein; tipo=digital con destacados da solo Drácula; q=zzzz devuelve []; prestar(999) lanza OutOfBoundsException.

# 5. Catálogo con GET

## 5.1 Escape HTML compartido

**1.** Crea vistas/ayudas.php con la función e():

```
function e(string $texto): string
{
    return htmlspecialchars(
        $texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'
    );
}
```

**2.** Incluye ayudas.php desde cada vista (o una sola vez antes de incluir la vista). No dupliques htmlspecialchars en el catálogo: usa siempre e().

## 5.2 Entrada pública del catálogo

**1.** En public/index.php carga vendor/autoload.php y la colección de datos/libros.php. Construye ArrayLibroRepository con esos libros y BibliotecaService con el repositorio (la interfaz).

**2.** Lee q, genero y tipo desde $_GET. Si una clave no existe o el valor no es string, usa cadena vacía (así evitas TypeError con strict_types ante ?q[]=x).

**3.** soloDestacados es true solo si existe la clave destacados en $_GET (como en P1); su ausencia es false.

**4.** Llama a filtrar, filas y resumen. Si llega ok=1 por la URL (tras un PRG), prepara un aviso de operación correcta; no implica que el alta persista en memoria.

**5.** Incluye vistas/catalogo.php al final.

## 5.3 Vista del catálogo

**1.** Documento HTML5 en español, UTF-8, h1 Catálogo de la biblioteca.

**2.** Formulario method="get" action="index.php" con:

| **Control** | **Construcción** |
| --- | --- |
| Texto | input text, id/name q, etiqueta Título o autor |
| Género | select genero: Todos "", Ciencia, Fantasía, Terror |
| Tipo | select tipo: Todos "", Papel, Digital |
| Destacados | checkbox name/id destacados value="1" |
| Enviar | button Buscar |

**3.** Tras cada búsqueda, recupera en los controles los valores enviados (value, selected, checked) escapando con e().

**4.** Tabla con columnas: título, autor, género, tipo (Papel/Digital), páginas, unidades, coste en euros (dos decimales) y un enlace Editar hacia libro-editar.php?id=…. Usa la clave id de cada fila.

**5.** Si hay portada, muestra una miniatura con src="/portada.php?nombre=…" (apartado 8). Si no hay filas, muestra No hay libros que coincidan y el resumen a cero.

**6.** Debajo: totales de $resumen. Enlaces a libro-crear.php y a index.php sin parámetros. Si hay aviso ok, muéstralo sin inventar persistencia.

> **Punto de control de 5.** Listado completo: 6 títulos, 11 unidades, 1860 páginas, 108,70 €. q=lem → solo Solaris. genero=terror → Drácula y Frankenstein. tipo=digital y destacados=1 → solo Drácula. q=zzzz → mensaje vacío y ceros. Cada fila tiene enlace de edición con su id.

# 6. Validator y LibroFormService

A diferencia de P1, aquí **sí** encapsulas las reglas: el script de public solo coordina; LibroFormService interpreta los campos; Validator reúne reglas reutilizables; Libro sigue protegiendo invariantes.

## 6.1 Validator

Crea src/Servicio/Validator.php (final). Cada regla recibe datos ya acotados y devuelve ?string: null si cumple, mensaje si falla.

Incluye al menos:

| **Método** | **Comportamiento** |
| --- | --- |
| requerido(string $valor, string $mensaje): ?string | trim vacío → mensaje |
| longitudMax(string $valor, int $max, string $mensaje): ?string | mb_strlen UTF-8 > max → mensaje |
| enLista(string $valor, array $permitidos, string $mensaje): ?string | comparación estricta |
| enteroEnRango(mixed $entrada, int $min, int $max, string $mensaje): ?string | solo string; filter_var FILTER_VALIDATE_INT; === false o fuera de rango → mensaje |
| fechaOpcional(mixed $entrada, string $mensaje): ?string | string vacía tras trim → null (OK); createFromFormat '!Y-m-d'; trata ValueError; format('Y-m-d') debe coincidir con el texto |
| checkboxOpcional(mixed $entrada): ?string | null/ausente lo decide el servicio; si llega valor, solo admite la cadena '1' |

Puedes añadir mensajes concretos por campo en LibroFormService y pasarlos a Validator.

## 6.2 LibroFormService::procesar

```
public function procesar(array $entrada): array
{
    // preparar valores y comprobar tipos
    // aplicar reglas
    return [
        'valores' => $valores,
        'errores' => $errores,
        'datos' => $errores === [] ? $datos : null,
    ];
}
```

**1.** Campos del formulario (sin correo: el éxito se comunica con PRG): tipo, titulo, autor, paginas, genero, unidades, fechaAlta, destacado, observaciones.

**2.** Para cada campo de texto: si falta, cadena vacía; si no es string, error de tipo en ese campo y valor de trabajo ''. No sustituyas un error de tipo por obligatorio o longitud.

**3.** Recorta textos con trim. Páginas y unidades: valida con enteroEnRango (1–3000 y 1–50). Género: ciencia|fantasia|terror. Tipo: papel|digital. Título ≤ 120, autor ≤ 100, observaciones ≤ 300 (observaciones pueden estar vacías).

**4.** Fecha: vacía → null en datos; con texto → DateTimeImmutable válido o error.

**5.** Destacado: ausencia de clave → false; presente y exactamente '1' → true; cualquier otro valor o array → error y valor false para redibujar.

**6.** datos solo se rellena si errores === []. Contiene tipos ya comprobados (enteros, ?DateTimeImmutable, bool) listos para construir o actualizar un Libro. No construyas el Libro dentro de procesar.

> **Punto de control de 6.** Desde prueba.php (o un script temporal): procesar con título de 120 caracteres OK y 121 con error; paginas "1" y "3000" OK, "0", "3001" y "12abc" error conservando el texto en valores; fecha "" → null, "2026-02-31" error, "2028-02-29" OK; destacado ausente → false, "1" → true, "2" error; entrada titulo => ['x'] → error de tipo sin avisos PHP.

# 7. Alta con POST, portada y PRG

## 7.1 Formulario compartido

**1.** vistas/formulario.php dibuja el alta y la edición. Controles con id, name y label. method="post" y enctype="multipart/form-data".

**2.** Campos: tipo (select), titulo, autor, paginas, genero, unidades, fechaAlta (placeholder YYYY-MM-DD), destacado (checkbox value 1), observaciones (textarea), portada (input file accept="image/jpeg,image/png,image/webp").

**3.** accept solo orienta al navegador; el servidor vuelve a comprobar. La portada es **opcional**.

**4.** Muestra errores junto a cada campo con e(). Conserva valores incorrectos al redibujar. Botón Guardar y enlace al catálogo.

## 7.2 PortadaService

Crea src/Servicio/PortadaService.php. Responsabilidades: validar la estructura de $_FILES['portada'], aplicar reglas de tamaño y MIME, generar el nombre, mover el archivo y poder retirarlo. Métodos sugeridos (puedes repartir auxiliares):

| **Método** | **Rol** |
| --- | --- |
| estructuraValida(?array $archivo): bool | error/size int, tmp_name string |
| esAusencia(array $archivo): bool | UPLOAD_ERR_NO_FILE (opcional) |
| validar(array $archivo): ?string | null = OK; mensaje si falla |
| guardar(array $archivo, string $directorio): string | nombre generado; lanza o devuelve error según tu diseño si falla el movimiento |
| eliminar(string $directorio, string $nombre): void | unlink controlado de un nombre generado |

Reglas de validación (temario UT3_02), en este orden tras estructura OK y archivo presente:

1. Código de error distinto de OK → mensaje.
2. Tamaño entre 1 byte y 2 MiB inclusive (2 * 1024 * 1024).
3. MIME con `new finfo(FILEINFO_MIME_TYPE)` sobre tmp_name; mapa:

```
'image/jpeg' => 'jpg',
'image/png'  => 'png',
'image/webp' => 'webp',
```

4. Nombre: bin2hex(random_bytes(16)) . '.' . extensión del mapa (no uses la extensión del cliente).
5. Destino solo bajo storage/portadas/. Comprueba directorio escribible y que el destino no exista.
6. move_uploaded_file y comprueba el booleano.

No trates name ni type del cliente como datos fiables para decidir el formato.

## 7.3 Coordinar public/libro-crear.php

**1.** GET: valores iniciales vacíos / false, sin errores; incluye el formulario.

**2.** POST: $resultado = LibroFormService::procesar($_POST). Si hay errores de campos, no muevas archivo.

**3.** Si los campos OK, inspecciona $_FILES['portada']:

- Entrada mal formada → error portada.
- Ausencia / NO_FILE → continuar sin portada.
- Archivo presente → validar; si OK, mover; si el movimiento falla → error.

**4.** Solo con errores === [] construye LibroPapel o LibroDigital, llama cambiarPortada si hay nombre, y repo->guardar. Marca $operacionCorrecta = true únicamente tras guardar.

**5.** Si ya moviste el archivo y guardar falla, compensa: intenta unlink del archivo nuevo y no dejes la operación como correcta.

**6.** Si $operacionCorrecta: PRG

```
header('Location: /index.php?ok=1', true, 303);
exit;
```

**7.** Si no, incluye el formulario con valores y errores. No envíes HTML antes del header de redirección.

**8.** Recuerda: el repositorio en memoria se reconstruye en la siguiente petición; el alta no aparece en el catálogo tras el PRG. ok=1 es solo un aviso. El archivo en disco sí puede permanecer (efecto colateral del almacenamiento en fichero).

> **Punto de control de 7.** GET muestra formulario vacío. POST inválido redibuja con errores y no crea archivo en storage/portadas. POST válido sin portada responde 303 a index.php?ok=1. POST válido con PNG pequeño guarda un nombre de 32 hex + .png. Un text/plain renombrado a .jpg se rechaza. Recargar la página de destino del PRG no reenvía el POST.

# 8. Servir portadas

## 8.1 public/portada.php

**1.** Lee nombre desde $_GET. Debe ser string y cumplir:

```
/\A[a-f0-9]{32}\.(jpg|png|webp)\z/
```

Si no, 404 y exit.

**2.** Ruta = directorio fijo storage/portadas + '/' + nombre. Nada de ../ ni rutas del usuario.

**3.** Si no is_file, o el MIME detectado con finfo no está en image/jpeg|png|webp, 404 y exit.

**4.** Cabeceras Content-Type del MIME y X-Content-Type-Options: nosniff. readfile($ruta); exit. No hagas echo del retorno de readfile.

## 8.2 Uso en vistas

```
<img src="/portada.php?nombre=<?= e($nombrePortada) ?>"
     alt="Portada del libro">
```

> **Punto de control de 8.** Una portada guardada se ve en el catálogo o en la ficha. ?nombre=../php.ini → 404. ?nombre=aaaa.txt → 404. Un archivo cuyo contenido no sea imagen admitida → 404 aunque el nombre tenga forma válida.

# 9. Edición

## 9.1 Localizar el libro

**1.** public/libro-editar.php lee id de $_GET. Debe ser string, FILTER_VALIDATE_INT y > 0. Si no, error general y no muestres el formulario de ficha.

**2.** buscarPorId; si null, error Libro no encontrado (o mensaje equivalente).

## 9.2 GET y POST

**1.** GET: precarga valores desde el objeto (fecha Y-m-d o '', destacado bool, tipo desde tipo(), etc.).

**2.** POST: procesar($_POST). Si hay errores, los valores enviados prevalecen sobre la precarga.

**3.** Portada:

| **Entrada** | **Efecto** |
| --- | --- |
| Sin archivo / NO_FILE | Conservar portada anterior |
| Archivo inválido | Error; conservar anterior; no mover |
| Archivo válido | Mover nuevo; actualizar referencia; si la operación OK y había anterior distinta, unlink de la antigua |
| Fallo tras mover | Restaurar referencia anterior; unlink del nuevo; propagar el error |

**4.** Con datos OK: actualizarDatos(...), cambiarPortada si corresponde, repo->actualizar($id, $libro).

**5.** Éxito → PRG (por ejemplo Location: /index.php?ok=1 o hacia libro-editar.php?id=…&ok=1), código 303 y exit.

**6.** Reutiliza vistas/formulario.php. Indica en la vista si es alta o edición (título, action del form).

> **Punto de control de 9.** Editar id=1 precarga Dune. Cambiar título y guardar → 303. Enviar páginas 0 → formulario con error y título anterior al POST conservado en valores. Sustituir portada deja de servir la antigua tras éxito. id=999 o id=abc → mensaje de no encontrado sin TypeError.

# 10. Pruebas unitarias con PHPUnit

## 10.1 Organización

Una clase de prueba por clase (o grupo claro) bajo tests/, namespace o use coherente con Composer. Extiende PHPUnit\Framework\TestCase. Preferible declare(strict_types=1).

Clases mínimas:

| **Archivo** | **Qué cubre** |
| --- | --- |
| tests/LibroTest.php | construcción, getters, prestar/devolver, cambiarPortada, actualizarDatos |
| tests/LibroPapelTest.php / LibroDigitalTest.php | tipo() y costeReposicionCentimos (o ambos en LibroTest) |
| tests/ArrayLibroRepositoryTest.php | IDs, guardar, actualizar, OutOfBoundsException |
| tests/BibliotecaServiceTest.php | filtrar/filas/resumen; prestar con stub/mock del repo |
| tests/ValidatorTest.php | reglas con DataProvider |
| tests/LibroFormServiceTest.php | procesar: valores, errores, datos null |
| tests/PortadaServiceTest.php | reglas puras (estructura, tamaño, mapa MIME); no simules subida HTTP con un temporal inventado para move_uploaded_file |

## 10.2 Técnicas del temario

**1.** assertSame($esperado, $obtenido) por defecto (tipo y valor). assertTrue/False, assertNull, assertCount, assertArrayHasKey.

**2.** expectException(Clase::class) antes de la llamada que debe fallar.

**3.** #[DataProvider('nombre')] con método public static que devuelve arrays de casos. Ejemplos de páginas: "1", "3000", "0", "3001", "12abc", ["412"].

**4.** setUp(): crea objetos frescos; no reutilices estado mutable entre tests.

**5.** Dobles sobre la **interfaz** LibroRepository:

- createStub + method('buscarPorId')->willReturn(null) → prestar debe lanzar OutOfBoundsException.
- createMock + expects($this->once())->method('…')->with(1) para verificar la colaboración.

**6.** Libro real aunque sea final en las subclases: no dobles el modelo de dominio en estas pruebas.

**7.** Borra prueba.php cuando las aserciones del modelo y del servicio estén en PHPUnit.

> **Punto de control de 10.** `composer test` termina en verde. Al menos un DataProvider, un expectException de dominio, un stub y un mock. Cobertura: no se exige porcentaje; sí casos que fallarían si romperías mb_strlen, filter_var o las claves de filtrar.

# 11. Verificación manual

## 11.1 Modelo, repo y consultas

| **Caso** | **Resultado esperado** |
| --- | --- |
| Colección inicial sin filtros | 6 títulos, 11 ud., 1860 pág., 108,70 € |
| q=lem | Solo Solaris |
| genero=terror | Drácula y Frankenstein |
| tipo=digital y destacados=1 | Solo Drácula |
| q=zzzz | Sin coincidencias; resumen a cero |
| Construcción con 0 páginas | InvalidArgumentException |
| Repo vacío | filas []; resumen cuatro ceros |
| prestar(999) | OutOfBoundsException |

## 11.2 Formulario y portada

| **Caso** | **Resultado esperado** |
| --- | --- |
| GET libro-crear.php | Formulario inicial sin errores |
| Título vacío / 121 caracteres | Error; no guarda |
| Páginas 1, 3000, 0, 3001, 12abc | Solo 1 y 3000 OK |
| Fecha "", 2028-02-29, 2026-02-31 | null / OK / error |
| Checkbox ausente / 1 / otro | false / true / error |
| name="titulo[]" | Error de tipo |
| Título con <>&" y páginas mal | Se reescribe escapado |
| PNG ≤ 2 MiB | Nombre generado y servido por portada.php |
| text/plain como .jpg | Rechazo por MIME |
| POST OK | 303 a index.php?ok=1; F5 no reenvía POST |
| Edición sin archivo | Conserva portada |
| Edición con archivo nuevo OK | Cambia referencia; antigua retirada |

# 12. Errores frecuentes

| **Síntoma** | **Causa habitual** |
| --- | --- |
| TypeError en filtrar o procesar | Llegó un array (?q[]=) sin is_string |
| Título cambia aunque páginas fallen en actualizarDatos | Asignaste antes de validar todo |
| Tras filtrar no hay enlace de edición | Usaste array_values y perdiste los ID |
| Recarga duplica el alta | Falta PRG 303 o falta exit tras Location |
| Portada “válida” que es un texto | Te fiaste de name/type del cliente |
| $_POST y $_FILES vacíos | Cuerpo > post_max_size |
| move_uploaded_file false en un test | El temporal no es una subida HTTP real |
| PHPUnit no encuentra clases | Falta dump-autoload o namespace incorrecto |
| Alta “desaparece” tras PRG | Esperado con repo en memoria; no es bug del PRG |

# 13. Repaso orientado al examen

## 13.1 Mapa rápido

| **Si el examen pide…** | **Repasa** |
| --- | --- |
| array_filter / map / reduce | BibliotecaService §4.3 |
| Validar entero o fecha | Validator + LibroFormService §6 |
| Redirección tras POST | §7.3 PRG |
| Subida segura | PortadaService §7.2 + portada.php §8 |
| Test con dependencia | stub/mock de LibroRepository §10 |
| No mutar si falla | actualizarDatos valida antes de asignar §3.2 |

## 13.2 Segunda pasada sin cheatsheet

Vuelve a implementar, en otro directorio o borrando src/public/vistas/tests (conserva composer.json, vendor y phpunit.xml si quieres), sin abrir el anexo A. Cronometra bloques de 30–45 minutos como en examen.

# Anexo A · Cheatsheet

## A.1 Escape

```
function e(string $texto): string
{
    return htmlspecialchars(
        $texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'
    );
}
```

## A.2 Lectura segura

```
$metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$esPost = $metodo === 'POST';
$entrada = $_POST['titulo'] ?? '';
if (!is_string($entrada)) {
    $entrada = '';
    // registrar error de tipo
}
$titulo = trim($entrada);
```

## A.3 Entero, fecha y checkbox

- Entero: filter_var($s, FILTER_VALIDATE_INT); fallo con === false; luego rango.
- Fecha: DateTimeImmutable::createFromFormat('!Y-m-d', $s); capturar ValueError; comparar format('Y-m-d') con $s.
- Checkbox: sin clave → false; clave con '1' → true; otro → error.

## A.4 Resultado de procesar

valores (redibujar) · errores (mensajes) · datos (null si hay errores; tipos listos si no).

## A.5 Repositorio

todos / buscarPorId / guardar (nuevo id) / actualizar (OutOfBoundsException si no existe). Claves = IDs.

## A.6 Checklist portada

Estructura → error code → tamaño 1…2MiB → finfo → mapa MIME → nombre aleatorio → move_uploaded_file → asociar → compensar si falla la operación → borrar antigua solo tras éxito.

## A.7 PRG

```
header('Location: /index.php?ok=1', true, 303);
exit;
```

Antes de cualquier HTML.

## A.8 PHPUnit (recordatorio)

assertSame, expectException, #[DataProvider], setUp, createStub, createMock + expects/once/with. Dobla la interfaz del repositorio.

## A.9 phpunit.xml

```
<?xml version="1.0" encoding="UTF-8"?>
<phpunit bootstrap="vendor/autoload.php">
  <testsuites>
    <testsuite name="Biblioteca">
      <directory>tests</directory>
    </testsuite>
  </testsuites>
</phpunit>
```

composer.json (fragmento):

```
"autoload": {
  "psr-4": { "TuNombre\\Biblioteca\\": "src/" }
},
"require-dev": {
  "phpunit/phpunit": "^12.5"
},
"scripts": {
  "test": "phpunit"
}
```
