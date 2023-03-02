# Instrucciones

En este apartado usted debe colocar los modelos del sistema.
En el caso del paquete innoboxrr/larapack-generator, buscará este apartado para insertar  las vistas y referencias al modelo.

La estrucutra del directorio es la siguinte 

 - /{Model}
 	- /forms
 		- CreateForm.vue
 		- EditForm.vue
 		- FilterForm.vue
 	- /views 
 		- AdminView.vue
 		- CreateView.vue
 		- EditView.vue
 		- ShowView.vue
 	- /widgets
 		- {Model}Crud.vue
 	- routes.js
 	- model.js

{Model} será reemplazado por el nombre del modelo.

Debe tenerse en cuenta que esta implementación requiere la instalación de:
 - VueCrud
 	- BreadcrumbComponent
 - InoboxrFormElements