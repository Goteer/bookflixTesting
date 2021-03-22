**Proyecto Bookflix**

Este es un proyecto-tarea para la facultad de informatica de la UNLP.
Se busca crear un clon de Netflix pero para lectura de libros en forma de una web-app que pueda usarse desde cualquier dispositivo.

----

*Diseño general*

Se utilizará php y una base de datos MySQL para almacenar y mostrar el contenido de la pagina
Como hay muchas paginas parecidas, casi todas las paginas se cargar desde una pagina de navegacion (pages/navegacion/nav.php). Se cargan con php en lugar de iframes 
para no tener que lidiar con mensajes asincronicos entre el documento principal y el iframe.
Ya hay un lector primitivo muy mal optimizado y un home que muestra los libros que esten en la carpeta pdf/pdfFiles, y busca tapas en pdf/img con la convencion
"<nombreArchivo>-tapa" y "<nombreArchivo>-contratapa".
La pagina nav.php navega por las otras paginas por medio de mensajes post a si mismo, para que al recargar sepa que pagina cargar.