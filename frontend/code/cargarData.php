<?php

/**
 * CREAR EL USUARIO SUPERADMIN Y ADMINISTRADOR
 * CREA LAS RUTAS PARA EL USUARIO SUPERADMIN, ADMINISTRADOR PERSONAL
 */
php yii rbac/init

/**
 * 	CREA LOS USUARIOS PARA CARGAR EL PERSONAL
 */
php yii rbac/crearuser

/**
 * 	INSERTA LOS DEPARTAMENTOS
 */
php yii rbac/insertardepart

/**
 *  INSERTA PERSONAL
 */
php yii rbac/insertarpersonal

/**
 *  REINICIA TODAS LAS TABLAS DEL SISTEMA AL CONTADOR DESDE 1
 */
php yii rbac/reiniciartablas
?>