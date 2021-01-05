<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\db\Connection;
use frontend\models\Usuario;

/**
 * @class RbacController
 */
class RbacController extends Controller
{
    // ejecutar el comando php yii rbac/init
    public function actionInit()
    {
        $usuario = new Usuario;
        $usuario->username = 'superadmintifm';
        $usuario->generateAuthKey();
        $usuario->password = '1nf0rm4t1c4.2020';
        $usuario->generatePasswordResetToken();
        $usuario->email = 'superadmintifm@tifm.com';
        $usuario->status = 1;
        $usuario->created_at = date( "Y-m-d h:i:s",time() );
        $usuario->generateEmailVerificationToken();
        if ($usuario->save()) {
            $auth = Yii::$app->authManager;
            // CREACIÓN DE PERMISOS
            $permisosuperadmin = $auth->createPermission('permisoSuperadmin');
            $auth->add($permisosuperadmin);

            $permisoadministrador = $auth->createPermission('permisoAdministrador');
            $auth->add($permisoadministrador);

            $permisopersonal = $auth->createPermission('permisoPersonal');
            $auth->add($permisopersonal);

            $permisodespacho = $auth->createPermission('permisoDespacho');
            $auth->add($permisodespacho);

            // RUTA PARA SUPERADMIN
            $pathsuperadminadmin = $auth->createPermission('/admin/*');
            $auth->add($pathsuperadminadmin);
            $pathsuperadmingii = $auth->createPermission('/gii/*');
            $auth->add($pathsuperadmingii);
            $pathsuperadminusuario = $auth->createPermission('/usuario/*');
            $auth->add($pathsuperadminusuario);
            $pathsuperadminpersonal = $auth->createPermission('/personal/*');
            $auth->add($pathsuperadminpersonal);
            $pathsuperadminpersexterno = $auth->createPermission('/persexterno/*');
            $auth->add($pathsuperadminpersexterno);


            // RUTAS PARA ADMINISTRADOR
            $pathpersonalindex = $auth->createPermission('/personal/index');
            $auth->add($pathpersonalindex);
            $pathpersonalpdf = $auth->createPermission('/personal/reportespdf');
            $auth->add($pathpersonalpdf);
            $pathpersexternoindex = $auth->createPermission('/persexterno/index');
            $auth->add($pathpersexternoindex);
            $pathpersexternocreate = $auth->createPermission('/persexterno/create');
            $auth->add($pathpersexternocreate);
            $pathpersexternoview = $auth->createPermission('/persexterno/view');
            $auth->add($pathpersexternoview);
            $pathpersexternodelete = $auth->createPermission('/persexterno/delete');
            $auth->add($pathpersexternodelete);

            // RUTAS PARA PERSONAL
            $pathpersonalcreate = $auth->createPermission('/personal/create');
            $auth->add($pathpersonalcreate);
            $pathpersonaldelete = $auth->createPermission('/personal/delete');
            $auth->add($pathpersonaldelete);
            $pathpersonalview = $auth->createPermission('/personal/view');
            $auth->add($pathpersonalview);
            $pathsite = $auth->createPermission('/site/*');
            $auth->add($pathsite);

            //AÑADIR RUTA A PERMISO SUPERADMIN
            $auth->addChild($permisosuperadmin,$pathsuperadminadmin);
            $auth->addChild($permisosuperadmin,$pathsuperadmingii);
            $auth->addChild($permisosuperadmin,$pathsuperadminusuario);
            $auth->addChild($permisosuperadmin,$pathsuperadminpersonal);
            $auth->addChild($permisosuperadmin,$pathsuperadminpersexterno);
            $auth->addChild($permisosuperadmin,$pathsite);

            //AÑADIR RUTA A PERMISO ADMINISTRADOR
            $auth->addChild($permisoadministrador,$pathpersonalindex);
            $auth->addChild($permisoadministrador,$pathpersonalpdf);
            $auth->addChild($permisoadministrador,$pathsite);
            $auth->addChild($permisoadministrador,$pathpersexternoindex);
            $auth->addChild($permisoadministrador,$pathpersexternocreate);
            $auth->addChild($permisoadministrador,$pathpersexternoview);
            $auth->addChild($permisoadministrador,$pathpersexternodelete);

            // AÑADIR RUTA A PERMISO DE USUARIO DESPACHO
            $auth->addChild($permisodespacho,$pathpersexternoindex);
            $auth->addChild($permisodespacho,$pathpersexternocreate);
            $auth->addChild($permisodespacho,$pathpersexternoview);
            $auth->addChild($permisodespacho,$pathpersexternodelete);

            //AÑADIR RUTA A PERMISO PERSONAL
            $auth->addChild($permisopersonal,$pathpersonalindex);
            $auth->addChild($permisopersonal,$pathpersonalcreate);
            $auth->addChild($permisopersonal,$pathpersonaldelete);
            $auth->addChild($permisopersonal,$pathpersonalview);
            $auth->addChild($permisopersonal,$pathsite);

            // CREACIÓN DE ROLES
            // ROLE "superadmin" y le asigna el permiso "permisoSuperadmin"
            $superadmin = $auth->createRole('superadmin');
            $auth->add($superadmin);
            $auth->addChild($superadmin, $permisosuperadmin);

            // ROLE "administrador" y le asigna el permiso "permisoAdministrador"
            $administrador = $auth->createRole('administrador');
            $auth->add($administrador);
            $auth->addChild($administrador, $permisoadministrador);

            // ROLE 'personal' y le asigna el permiso "permisoPersonal"
            $personal = $auth->createRole('personal');
            $auth->add($personal);
            $auth->addChild($personal, $permisopersonal);

            // ROLE 'personal' y le asigna el permiso "permisoPersonal"
            $despacho = $auth->createRole('despacho');
            $auth->add($despacho);
            $auth->addChild($despacho, $permisodespacho);

            // ASIGNACION DE ROLES POR IDs devuelto por IdentityInterface::getId()
            $Rolesuperadmin = $auth->getRole('superadmin');
            $auth->assign( $Rolesuperadmin, $usuario->getId() );

            // INSERTA EL USUARIO ADMINISTRADOR Y ASIGNA EL ROLE administrador
            unset($usuario);
            $usuario = new Usuario;
            $usuario->username = 'administrador';
            $usuario->generateAuthKey();
            $usuario->password = '4dm1n1str4d0r';
            $usuario->generatePasswordResetToken();
            $usuario->email = 'administradortifm@tifm.com';
            $usuario->status = 1;
            $usuario->created_at = date( "Y-m-d h:i:s",time() );
            $usuario->generateEmailVerificationToken();
            if ($usuario->save()) {
                $Roleadministrador = $auth->getRole('administrador');
                $auth->assign( $Roleadministrador, $usuario->getId() );
            }
        }
    }

    public function actionInsertardepart()
    {
        $command = Yii::$app->db->createCommand("insert into comedor.departamento (nombdepart) values('Auditoria Interna')");
        $command->execute();
        $command = Yii::$app->db->createCommand("insert into comedor.departamento (nombdepart) values('Bienes Nacionales')");
        $command->execute();
        $command = Yii::$app->db->createCommand("insert into comedor.departamento (nombdepart) values('Compras')");
        $command->execute();
        $command = Yii::$app->db->createCommand("insert into comedor.departamento (nombdepart) values('Consultoria Juridica')");
        $command->execute();
        $command = Yii::$app->db->createCommand("insert into comedor.departamento (nombdepart) values('Contabilidad')");
        $command->execute();
        $command = Yii::$app->db->createCommand("insert into comedor.departamento (nombdepart) values('Corporación de Turismo Insular Miranda')");
        $command->execute();
        $command = Yii::$app->db->createCommand("insert into comedor.departamento (nombdepart) values('Dirección General de Despacho')");
        $command->execute();
        $command = Yii::$app->db->createCommand("insert into comedor.departamento (nombdepart) values('Dirección de Administración')");
        $command->execute();
        $command = Yii::$app->db->createCommand("insert into comedor.departamento (nombdepart) values('Dirección de Gestion Comunicacional')");
        $command->execute();
        $command = Yii::$app->db->createCommand("insert into comedor.departamento (nombdepart) values('Dirección de Presupuesto')");
        $command->execute();
        $command = Yii::$app->db->createCommand("insert into comedor.departamento (nombdepart) values('Dirección de Protección Civil y Administración de Desastres')");
        $command->execute();
        $command = Yii::$app->db->createCommand("insert into comedor.departamento (nombdepart) values('Dirección de Talento Humano')");
        $command->execute();
        $command = Yii::$app->db->createCommand("insert into comedor.departamento (nombdepart) values('Dirección de Tecnologia e Informatica')");
        $command->execute();
        $command = Yii::$app->db->createCommand("insert into comedor.departamento (nombdepart) values('Fundación de Alimentos Insular Miranda')");
        $command->execute();
        $command = Yii::$app->db->createCommand("insert into comedor.departamento (nombdepart) values('Fundación de Investigaciones Maritimas Insular Miranda')");
        $command->execute();
        $command = Yii::$app->db->createCommand("insert into comedor.departamento (nombdepart) values('Secretaria de Apoyo y Servicios Publicos')");
        $command->execute();
        $command = Yii::$app->db->createCommand("insert into comedor.departamento (nombdepart) values('Secretaria de Cultura')");
        $command->execute();
        $command = Yii::$app->db->createCommand("insert into comedor.departamento (nombdepart) values('Secretaria de Infraestructura y Proyectos')");
        $command->execute();
        $command = Yii::$app->db->createCommand("insert into comedor.departamento (nombdepart) values('Secretaria de Prevención y Seguridad Ciudadana')");
        $command->execute();
        $command = Yii::$app->db->createCommand("insert into comedor.departamento (nombdepart) values('Secretaria de Protección Social')");
        $command->execute();
        $command = Yii::$app->db->createCommand("insert into comedor.departamento (nombdepart) values('Secretaria de Salud')");
        $command->execute();
        $command = Yii::$app->db->createCommand("insert into comedor.departamento (nombdepart) values('Servicio Aeroportuario Insular Miranda')");
        $command->execute();
        $command = Yii::$app->db->createCommand("insert into comedor.departamento (nombdepart) values('Servicio de Administración Tributaria Insular Miranda')");
        $command->execute();
        $command = Yii::$app->db->createCommand("insert into comedor.departamento (nombdepart) values('Tesoreria')");
        $command->execute();

    }

    public function actionInsertarpersonal()
    {
        $command = Yii::$app->db->createCommand("
            insert into comedor.personal (ci,nombcompleto,sexo,fkuser,fkdepart)
            values
            -- Auditoria Interna
            ('6.404.833',   'MUJICA SONIA MARQUIS', 'F', 3, 1),
            ('8.464.954',   'ZUÑIGA JIMENEZ YVON CAROLINA', 'F', 3, 1),
            ('5.878.640',   'FERNANDEZ JOSE GREGORIO', 'M', 3, 1),
            ('18.324.913',  'UGUETO BLANCO ABELYS DANIELA', 'F', 3, 1),
            ('25.831.204',  'MALAVE MANABRE RAINEER JOSE', 'M', 3, 1),
            -- Bienes Nacionales
            ('5.878.640',   'FERNANDEZ JOSE GREGORIO', 'M', 4, 2),
            ('18.324.913',  'UGUETO BLANCO ABELYS DANIELA', 'F', 4, 2),
            ('25.831.204',  'MALAVE MANABRE RAINEER JOSE', 'M', 4, 2),
            -- Compras
            ('16.726.556',	'VARGAS PEÑATE AYARITH', 'F', 5, 3),
            ('17.100.863',	'RAMIREZ RODRIGUEZ JUAN CARLOS', 'M', 5, 3),
            -- Consultoria Juridica
            ('13.564.006',	'AVILA CONTRETAS YAISMEL DEL CARMEN', 'F', 6, 4),
            ('14.719.591',	'GINER DURAN ADRIANA GRACIELA', 'F', 6, 4),
            ('16.369.775',	'MAGALLANES GRILLET MARCO ANTONIO', 'M', 6, 4),
            ('20.629.023',	'TIRADO MUJICA KARYID DAKARI', 'F', 6, 4),
            ('22.504.965',	'GONZALEZ LEON ANDERSON JOSE', 'M', 6, 4),
            ('23.644.716',	'SUNIAGA RAMIREZ YILSIREET DEL VALLE', 'F', 6, 4),
            ('26.995.069',	'PAREDES RUIZ KATIHUSKA CAROLINA', 'F', 6, 4),
            ('27.421.660',	'RENGIFO CASTRO ANTONELLA VICTORIA', 'F', 6, 4),
            --Contabilidad
            ('17.117.396',	'NUÑEZ FERNANDEZ LORENDIE CRISTINA', 'F', 7, 5),
            ('18.555.656',	'BARRADAS TORO KEYLA BIANETT', 'F', 7, 5),
            ('25.701.765',	'GONZALEZ CANONICO MIGUEL ANGEL', 'M', 7, 5),
            ('26.122.846',	'JARAMILLO VALERA WILMER DANIEL', 'M', 7, 5),
            -- Corporación de Turismo Insular Miranda
            ('6.440.042',	'CASANOVA DE LANDAETA EUNICE MARGARITA', 'F', 8, 6),
            ('10.349.198',	'RAVELO BARRIOS ELBA COROMOTO', 'F', 8, 6),
            ('15.545.319',	'VILA CHONA LUIS', 'M', 8, 6),
            ('17.382.549',	'ABREU PEREZ ANGRIS NAIROVIS', 'F', 8, 6),
            ('18.324.376',	'GUZMAN MARTINEZ JOSGREYMER MILAGROS DE LOURDES', 'F', 8, 6),
            ('20.192.520',	'PERDOMO UGUETO JESUS EMMANUEL', 'M', 8, 6),
            ('21.195.127',	'LOPEZ BORGES GABRIEL ANTONIO', 'M', 8, 6),
            ('21.195.140',	'LOPEZ BORGES CARLOS MOISES', 'M', 8, 6),
            ('24.181.392',	'SALAZAR HIDALGO HENRY LEONARDO', 'M', 8, 6),
            ('24.333.965',	'SALAZAR HIDALGO VICTOR DANIEL', 'M', 8, 6),
            -- Dirección General de Despacho
            ('6.911.971',   'JIMENEZ RATTIA ELADIO JOSE GREGORIO', 'M', 9, 7),
            ('7.088.433',   'GUTIERREZ FALCON ALVARO HYLDEGARD', 'M', 9, 7),
            ('12.749.484',	'RONDON QUINTERO YASMIN YOLEIDY', 'F', 9, 7),
            ('14.788.233',	'BICEÑO SANCHEZ AMAURIS JOSÉ', 'M', 9, 7),
            ('15.123.983',	'PEÑA RODRIGUEZ DANIEL JOSE', 'M', 9, 7),
            ('20.638.325',	'RODRIGUEZ MENESES VISNEIDY DEL C', 'F', 9, 7),
            ('25.091.749',	'GIRON HERNANDEZ ANDREA VALENTINA', 'F', 9, 7),
            ('26.901.902',	'GUERRA CASTRO JONAIDY NOHELY', 'F', 9, 7),
            -- Dirección de Administración
            ('9.143.398',   'BLASTOS DE VOLCAN ILIANI PASTORA', 'F', 10, 8),
            ('11.603.637',	'CHICO PADILLA HENDRIKS MIGUEL', 'M', 10, 8),
            ('11.641.329',	'DURAND ASTUDILLO HUMBERTO ANTONIO', 'M', 10, 8),
            ('17.630.924',	'MIQUELENA CALDENA MARISELYS CAROLINA', 'F', 10, 8),
            ('24.750.264',	'PONCE RUIZ BRUNO DAVID', 'M', 10, 8),
            -- Dirección de Gestion Comunicacional
            ('19.089.326',	'MADRIZ YBARRA ALEXIS FLORENTINO', 'M', 11, 9),
            ('21.159.093',	'DUGARTE PEÑA WENDY COROMOTO', 'F', 11, 9),
            ('23.944.259',	'AGUILAR MENDOZA ASTRID CAROLINA', 'F', 11, 9),
            ('24.178.477',	'GUTIERREZ SALAZAR CARMELI SINAI', 'F', 11, 9),
            ('24.334.057',	'RICARDO ALBERTO LICETT PALACIOS', 'M', 11, 9),
            ('25.723.620',	'SUAREZ MANAURE KARIBAY', 'F', 11, 9),
            ('26.250.567',	'LUNAR MOLINA EDWARD ENRIQUE', 'M', 11, 9),
            ('27.271.596',  'PINO NAVAS SEYCHELLES VICTORIA', 'F', 11, 9),
            -- Dirección de Presupuesto
            ('3.485.084',   'DAZA ROMIJN ALEJANDRO JOSE', 'M', 12, 10),
            ('10.369.016',	'QUINTERO ARTEAGA JOSE ANTONIO', 'M', 12, 10),
            ('12.617.838',	'RODRIGUEZ MARQUEZ MARIA GEORGINA', 'F', 12, 10),
            ('13.613.323',	'TARACHE PATINEZ JOSE GREGORIO', 'M', 12, 10),
            ('25.824.437',	'VELIZ CAMPOS ERICK OSCAR', 'M', 12, 10),
            -- Dirección de Protección Civil y Administración de Desastres
            ('19.369.400',	'PARACO PEREZ ARGENI DAVID', 'M', 13, 11),
            ('21.192.846',	'ECHARRY LIENDO GYRALBERT DANIEL', 'M', 13, 11),
            ('21.195.239',	'SANCHEZ RODRIGUEZ ROTNES JOSE', 'M', 13, 11),
            ('25.000.422',	'ZURITA RENGIFO YORGENIS JAVIER', 'M', 13, 11),
            ('26.180.133',	'GOMEZ ROSENDO JOSE ANGEL', 'M', 13, 11),
            ('27.163.046',	'ROMERO DIAZ JOFRE JOSE SAMUEL', 'M', 13, 11),
            ('27.857.068',	'ESCOBAR SALAZAR ERWIN JOSE', 'M', 13, 11),
            -- Dirección de Talento Humano
            ('6.458.358',   'QUIJANO VILLASMIL JAVIER OSWALDO', 'M', 14, 12),
            ('10.823.610',	'DIAZ VARGAS MAYDOLET', 'F', 14, 12),
            ('11.993.585',	'ANGULO UZCATEGUI YOSMAR DESIREE', 'F', 14, 12),
            ('13.086.214',	'GARCIA SANCHEZ KARELYS', 'F', 14, 12),
            ('18.092.722',	'CARDOZO GONZALEZ MARYUMIRLE ROSALIA', 'F', 14, 12),
            ('18.595.056',	'BELLO BRITO ANIUSKA IVONETH', 'F', 14, 12),
            ('18.899.509',	'MONTES HIGUERA MARTHA NOHELIA', 'F', 14, 12),
            ('18.910.287',	'BERRIOS CHACON DAYLENIZ', 'F', 14, 12),
            ('19.465.180',	'MATA FRAY ALEJANDRA', 'F', 14, 12),
            ('19.884.855',	'BRAVO TERAN MARICRUZ', 'F', 14, 12),
            ('20.095.600',	'MEDINA TORRES MARIA FERNANDA', 'F', 14, 12),
            ('21.667.422',	'HERNANDEZ PIÑA JOSE DAVID', 'M', 14, 12),
            ('23.644.715',	'SUNIAGA RAMIREZ GEORDY JOSE', 'M', 14, 12),
            ('23.946.338',	'FERRER BELGODERI LUIS MIGUEL', 'M', 14, 12),
            ('25.466.908',	'BERNAL ECHETO ERIKA FABIANA', 'F', 14, 12),
            ('26.163.734',	'VALERIO ROMERO JOSELYN DEL CARMEN', 'F', 14, 12),
            ('26.552.274',	'MARTINEZ BELLO VALERIA ALEJANDRA', 'F', 14, 12),
            ('28.100.364',	'RODRIGUEZ TORRES KLUIVERTH ALEJANDRO', 'M', 14, 12),
            -- Dirección de Tecnologia e Informatica
            ('16.851.263',	'GUERRERO MARTINEZ JOSE RICARDO', 'M', 15, 13),
            ('18.032.739',	'RAMIREZ RODRIGUEZ JHON ADULFO', 'M', 15, 13),
            ('18.700.371',	'BLANCO PEREIRA LUIS DAVID', 'M', 15, 13),
            ('18.740.500',	'CAMACHO OCHOA EDGAR ANTONIO', 'M', 15, 13),
            ('20.385.493',	'YAMIN SILVA LEONEL RAMON', 'M', 15, 13),
            ('20.754.372',	'GALAVIS ROJAS INGRID ABIGAIL', 'F', 15, 13),
            ('24.333.504',	'VARGAS PEÑATE KELLY ANDREINA', 'F', 15, 13),
            -- Fundación de Alimentos Insular Miranda
            ('6.932.425',   'SANCHEZ TORRES MARIBEL GREGORIA', 'F', 16, 14),
            ('16.028.391',	'DURAN BLANCO MILEIDY DEL CARMEN', 'F', 16, 14),
            ('16.308.733',	'FRANQUIS VIÑOLES ELENA DEL VALLE CONCEPCION', 'F', 16, 14),
            ('17.587.446',	'CASTRO BERNAL KEISY ROSMELY', 'F', 16, 14),
            ('21.302.194',	'CHAVEZ ANGULO WISLEYDY KARINA', 'F', 16, 14),
            -- Fundación de Investigaciones Maritimas Insular Miranda
            ('5.977.236',   'GARCIA OROPEZA JOSE ANTONIO', 'M', 17, 15),
            ('9.822.175',   'VIÑA GARCIA JESUS RAFAEL', 'M', 17, 15),
            ('10.253.288',	'LUCENA TORRES JOSE GREGORIO', 'M', 17, 15),
            ('10.808.874',	'GARCIA CASTRO ELIO GUSMAN', 'M', 17, 15),
            ('11.124.494',	'ROJAS OROPEZA TOMAS ENRIQUE', 'M', 17, 15),
            ('13.152.447',	'CALLES HERNANDEZ DIXON ENRIQUE', 'M', 17, 15),
            ('13.875.163',	'LORETO YAZORA NALLY KATINA', 'F', 17, 15),
            ('14.889.955',	'BERTRAND BRAZON LORENZO ANTONIO', 'M', 17, 15),
            ('18.202.882',	'HERNANDEZ DOURANIAN JOSBELY NATALI', 'F', 17, 15),
            ('20.957.408',	'PEREZ TORREALBA GENESIS ALEJANDRA', 'F', 17, 15),
            ('22.618.885',	'CANELON ALFARO CARLOS EDUARDO', 'M', 17, 15),
            ('24.792.873',	'GARRIDO VAZQUEZ MIGUEL JOSE', 'M', 17, 15),
            ('27.163.151',	'PERDOMO TORREALBA VICTOR ALEJANDRO', 'M', 17, 15),
            ('27.598.498',	'RENGIFO CABELLO ORIANA VALENTINA', 'F', 17, 15),
            -- Secretaria de Apoyo y Servicios Publicos
            ('6.169.926',   'ORTA MARRON JOSE CARLOS', 'M', 18, 16),
            ('6.682.380',   'PEREIRA MARIA ALEJANDRA', 'F', 18, 16),
            ('6.836.173', 	'LEON ROMERO MANUEL FELIPE', 'M', 18, 16),
            ('7.474.378', 	'MENDEZ COLINA CARLOS GREGORIO', 'M', 18, 16),
            ('7.925.647', 	'ZAMBRANO RODRIGUEZ WALDIMIR ENRIQUE', 'M', 18, 16),
            ('8.608.096', 	'NAVA NARANJO JOSE GREGORIO', 'M', 18, 16),
            ('9.993.617',   'SALAZAR YRIDIA DEL VALLE', 'F', 18, 16),
            ('10.513.121',	'HIDALGO ANA BELKIS', 'F', 18, 16),
            ('10.578.858',	'NARVAEZ SALAZAR AMERICA GRICELIA', 'F', 18, 16),
            ('11.063.841',	'SILVA MURO JOSE ALEXANDER', 'M', 18, 16),
            ('11.399.851',	'TORREALBA QUINTERO MARIA LUSMILA', 'F', 18, 16),
            ('11.478.682',	'ATACHO ARCAYA RONNY JOSE', 'M', 18, 16),
            ('11.674.810',	'RAMIREZ ROMERO GUSTAVO EDUARDO', 'M', 18, 16),
            ('11.675.971',	'VILLANUEVA ORLANDO JOSE', 'M', 18, 16),
            ('12.356.831',	'URDANETA GUILLEN LERY DEL CARMEN', 'F', 18, 16),
            ('12.388.688',	'ARRIECHE LARA JOSE RAFAEL', 'M', 18, 16),
            ('12.429.209',	'AGREDA GILBERTO RAMON', 'M', 18, 16),
            ('12.688.523',	'TORRES FERNANDEZ NUBIA CAROLINA', 'F', 18, 16),
            ('12.960.034',	'UZCATEGUI JOEL DEL JESUS', 'M', 18, 16),
            ('13.224.011',	'COVA HURTADO DEINNIS EDUARDO', 'M', 18, 16),
            ('14.383.439',	'HERNANDEZ GAUNA CARLOS EDUARDO', 'M', 18, 16),
            ('15.238.576',	'COBIS VENTURA JOAQUIN LEONARDO', 'M', 18, 16),
            ('15.962.830',	'TERAN CHACON BRIGITT JOHANA', 'F', 18, 16),
            ('16.031.013',	'FERNANDEZ MAURERA DAVISON SIMON', 'M', 18, 16),
            ('16.627.568',	'GIL SALAZAR LUIS EOBARDO', 'M', 18, 16),
            ('17.425.223',	'TORREALBA CARAO LEYNIS CAROLINA', 'F', 18, 16),
            ('17.815.333',	'AGUANA LINARES JESSIKA ANDREINA', 'F', 18, 16),
            ('17.928.105',	'VEGAS PIÑANGO RONALD DANIEL', 'M', 18, 16),
            ('18.151.520',	'PRIMERA GONZALEZ EDBER JESUS', 'M', 18, 16),
            ('18.530.126',	'HERNANDEZ NIEVES DOUGLAS JESUS', 'M', 18, 16),
            ('18.761.343',	'VALERO SANCHEZ WINNY YENMARIE', 'F', 18, 16),
            ('19.079.557',	'LOPEZ GOMEZ ARIAN RAFAEL', 'M', 18, 16),
            ('19.350.149',	'GOMEZ SANCHEZ ROSALYN CAROLINA', 'F', 18, 16),
            ('19.417.995',	'PEREZ FLORES JHONSY JOSE', 'M', 18, 16),
            ('19.605.919',	'PALMA TORRES CARLOS EDUARDO', 'M', 18, 16),
            ('19.913.439',	'TERAN MELO NESTOR ALEJANDRO', 'M', 18, 16),
            ('20.908.758',	'OLIVO OLIVO JOSE JAVIER', 'M', 18, 16),
            ('21.466.268',	'GALENO TERAN DIANA AURALY', 'F', 18, 16),
            ('22.671.423',	'RADA TORRES JOHANNA IRAILY', 'F', 18, 16),
            ('22.922.805',	'GIL MUNDARAIN CRISTOBAL JOSE', 'M', 18, 16),
            ('22.975.152',	'BETANCOURT CEUTA HECTOR JESUS', 'M', 18, 16),
            ('23.530.395',	'RODRIGUEZ APISCOPE DELVIN DEL JESUS', 'M', 18, 16),
            ('23.530.631',	'SANCHEZ RAMOS CARLOS JAVIER', 'M', 18, 16),
            ('23.705.260',	'FLORES MUÑOZ RAMON CARACIOLO', 'M', 18, 16),
            ('24.274.636',	'HERNANDEZ HERRERA YARMY ALEXANDER', 'M', 18, 16),
            ('24.971.056',	'RODRIGUEZ JAURE ELWIN JOSE', 'M', 18, 16),
            ('25.328.420',	'PERALTA BRETO ALEJANDRO ANTONIO', 'M', 18, 16),
            ('25.503.681',	'GIL AGUILERA DENNY JOSE', 'M', 18, 16),
            ('25.503.682',	'MENDOZA RODRIGUEZ REINALDO ALEXANDER', 'M', 18, 16),
            ('25.740.374',	'YANEZ LEMUS EDWIN ALEXANDER', 'M', 18, 16),
            ('27.175.145',	'REYES TERAN WILGER JOHALBERT', 'M', 18, 16),
            ('27.866.524',	'CATARI TIBERIO JOHAN JOSE', 'M', 18, 16),
            ('28.200.329',	'TORREALBA CANELON CARLOS JAVIER', 'M', 18, 16),
            ('83.140.297',	'VANEGAS VILORIA JUAN CARLOS', 'M', 18, 16),
            -- Secretaria de Cultura
            ('3.019.940',   'PEREZ ROSSI IVAN JOSE', 'M', 19, 17),
            ('4.168.189',   'CHACON SALAZAR DOMINGO RAFAEL', 'M', 19, 17),
            ('4.369.332',   'PACHECO CROQUER JOSE FRANCISCO', 'M', 19, 17),
            ('4.435.177',   'LITVINOV FRANCIA ANDRES ELOY', 'M', 19, 17),
            ('5.083.067',   'GUTIERREZ SANCHEZ DAISY JOSEFINA', 'F', 19, 17),
            ('6.661.684',   'LISTA RONDON ADRIAN OSCAR', 'M', 19, 17),
            ('6.806.685',   'RODRIGUEZ ROMERO CELESTE ANAHIS', 'F', 19, 17),
            ('11.163.168',  'MOLINA RUIZ SILVIA ESPERANZA', 'F', 19, 17),
            ('16.033.263',  'PACHECO CASTRO MIRLA ELVIRA', 'F', 19, 17),
            -- Secretaria de Infraestructura y Proyectos
            ('4.167.704',   'MARINE FERNANDEZ CARMEN MILAGROS', 'F', 20, 18),
            ('4.822.112',   'TORO LOPEZ LESBIA DEL VALLE', 'F', 20, 18),
            ('5.968.250',   'ECHEZURIA PEREZ ALFREDO ALEXIS', 'M', 20, 18),
            ('6.521.843',   'RIVERO GRANADINO JESUS ANTONIO', 'M', 20, 18),
            ('8.711.216',   'MARQUEZ RUJANO ESTHELA DEL CARMEN', 'F', 20, 18),
            ('12.374.168',  'MENDEZ RIVAS ARELIS MASIEL', 'F', 20, 18),
            ('13.637.312',  'MALDONADO VELASQUEZ VIRGINIA TERESA', 'F', 20, 18),
            ('14.471.546',  'ALMEIDA MEJIAS GILDA LISBETH', 'F', 20, 18),
            ('15.167.239',	'RODRIGUEZ JARAMILLO HECTOR ENRIQUE', 'M', 20, 18),
            ('15.686.505',	'LEON MORALES JOSELYN MARIA', 'F', 20, 18),
            ('15.705.133',	'SCALA TAPISQUEN FRANK', 'M', 20, 18),
            ('19.464.871',	'MARQUEZ RODRIGUEZ LUIS ALEJANDRO', 'M', 20, 18),
            ('20.001.239',	'DIAZ CORTEZ LUIS ALBERTO', 'M', 20, 18),
            ('20.399.186',	'SAEZ MIJARES ROSMERIS', 'F', 20, 18),
            ('22.924.716',	'TINEO SALCEDO LUISMANUEL WENCESLAO', 'M', 20, 18),
            ('24.530.057',	'GALLEGOS CHAVEZ LISBETH JOSEFINA', 'F', 20, 18),
            ('25.369.892',	'HERNANDEZ DURAN ELVIS SAID', 'M', 20, 18),
            -- Secretaria de Prevención y Seguridad Ciudadana
            ('4.616.597',   'FARIAS MERCEDES DEL VALLE', 'F', 21, 19),
            ('6.524.344',   'ESPINOZA LEON EDUARDO JACOBO', 'M', 21, 19),
            ('7.565.233',   'LEVANE MARQUEZ JUAN FRANCISCO CAMILO', 'M', 21, 19),
            ('10.312.742',  'VALERA TORREALBA ALEXY DEL CARMEN', 'M', 21, 19),
            ('10.577.596',  'BRITO RODRIGUEZ ELCIDE RAMON', 'M', 21, 19),
            ('12.393.033',  'HERNANDEZ CHAURAN DARWIN MOISES', 'M', 21, 19),
            -- Secretaria de Protección Social
            ('4.273.014',   'HERRERA JORGE ALBERTO', 'M', 22, 20),
            ('15.067.925',  'ROQUE ALVAREZ ELIX DANIEL', 'M', 22, 20),
            ('15.182.515',  'ZAMBRANO HERNANDEZ JOANA YUSMELIA', 'F', 22, 20),
            ('16.370.912',	'HERNANDEZ CARVAJAL JOSE LUIS', 'M', 22, 20),
            ('18.463.529',	'GAZCON GONZALEZ EUCLIDES ENRIQUES', 'M', 22, 20),
            ('18.825.570',	'ACUÑA GOLINDANO EGDYMAR PATRICIA', 'F', 22, 20),
            ('20.913.901',	'SANCHEZ APONTE ANTHONY EDUARDO', 'M', 22, 20),
            -- Secretaria de Salud
            ('19.873.506',	'LISTA YNFANTE ADRIMAR MILAGROS', 'F', 23, 21),
            -- Servicio Aeroportuario Insular Miranda
            ('6.497.136',   'PEDRIQUE RAMIREZ HUGO JOSE', 'M', 24, 22),
            ('7.998.971',   'BARRERA CARRILLO JAVIER EDVIGIS', 'M', 24, 22),
            ('10.485.291',	'PERNALETE GIMENEZ EILING DOLORES', 'F', 24, 22),
            ('11.640.856',	'ACOSTA MONGES JOSEMIT COROMOTO', 'F', 24, 22),
            ('12.337.075',	'CASARES LAYA CAROLINGER MERCEDES', 'F', 24, 22),
            ('12.717.081',	'LOPEZ UGUETO DIONEDY JESUS', 'M', 24, 22),
            ('15.528.742',	'PINTO SALAZAR OSMAR JAVIER', 'M', 24, 22),
            ('18.730.378',	'RIVAS OSORIO YRVIN YOSMER', 'M', 24, 22),
            ('19.087.088',	'VEGAS HIDALGO EDUARD FELICIANO', 'M', 24, 22),
            ('19.628.917',	'AMUNDARAIN MARCANO NAKARY MILANGELA', 'F', 24, 22),
            ('20.127.294',	'BARRIOS JOSE RAFAEL', 'M', 24, 22),
            ('20.307.283',	'PEÑALOZA RAMIREZ WILLIAMS ALEJANDRO', 'M', 24, 22),
            ('20.308.903',	'DAVILA LOPEZ YUTSELIS GERTRUDIS', 'F', 24, 22),
            ('20.309.041',	'MEZA DELGADO LISNEY CAROLINA', 'F', 24, 22),
            ('20.638.873',	'ROMERO MIJARES VICTOR ALONZO', 'M', 24, 22),
            ('22.278.513',	'ALVAREZ MARIN ISGREYLIS URIMARE', 'F', 24, 22),
            ('24.177.844',	'GARCIA MARTINEZ KEIBER JESUS', 'M', 24, 22),
            ('24.436.826',	'GONZALEZ OVALLES YANKARLOS JESUS', 'M', 24, 22),
            ('24.523.282',  'VILLARROEL SUAREZ ANGELICA MARIA', 'F', 24, 22),
            ('24.895.532',	'ELISTA DELGADO JEHOVA JESUS', 'M', 24, 22),
            ('25.704.565',	'TARACHE ZAMBRANO JHORGELYNS ARIATNA', 'F', 24, 22),
            ('25.870.689',	'PEREZ RODRIGUEZ JHONEIKER MANUEL', 'M', 24, 22),
            ('26.647.762',	'ARANA AGUILAR CESAR EDUARDO', 'M', 24, 22),
            ('26.683.459',	'ACEVEDO UTRERA JOSE LEONARDO', 'M', 24, 22),
            ('26.741.824',	'RIVERA RIOS JORGE JESUS', 'M', 24, 22),
            ('27.042.335',	'MARIN HERNANDEZ YORKAEFF OLEVINSKI', 'M', 24, 22),
            -- Servicio de Administración Tributaria Insular Miranda
            ('12.111.413',	'CARABALLO JAVIER AMADO', 'M', 25, 23),
            ('12.352.551',	'QUINTERO QUINTERO KARLA YOCELIN', 'F', 25, 23),
            ('14.428.573',	'MARCANO GUAIMARA ZOMANGELA', 'F', 25, 23),
            ('14.558.797',	'PAEZ BARRIOS ELVIMAR', 'F', 25, 23),
            ('15.004.197',	'MONGE RODRIGUEZ VIRGINIA BEATRIZ', 'F', 25, 23),
            ('16.110.597',	'GALINDO HERNANDEZ YUSELY', 'F', 25, 23),
            ('17.441.551',	'BADILLA AMUNDARY LOURDES  ANTONIETA', 'F', 25, 23),
            ('18.011.033',	'INOJOSA BERNAL JENIREE COROMOTO', 'F', 25, 23),
            ('18.397.789',	'PACHECO RAMIREZ LUIS ANGEL', 'M', 25, 23),
            ('19.468.548',	'TORREALBA ALVAREZ LUIS DANIEL', 'M', 25, 23),
            ('19.633.544',	'ARELLANO TAJAN MARIA GABRIELA', 'F', 25, 23),
            ('25.959.248',	'TRUJILLO GOMEZ LUIS MANUEL', 'M', 25, 23),
            -- Tesoreria
            ('11.063.335',	'TORMES HERNANDEZ JOSE LUIS', 'M', 26, 24),
            ('14.519.341',	'OROPEZA CAMPOS TERESA DE JESUS', 'F', 26, 24),
            ('17.691.212',	'TORRES USTARIS ANABEL ANAIZ', 'F', 26, 24),
            ('25.217.536',	'ACOSTA VALERO DOUGLAS RAFAEL', 'M', 26, 24)
        ");
        $command->execute();
    }

    public function actionCrearuser()
    {
        $personal = [
            '01' =>  'tifmAI',
            '02' =>  'tifmBN',
            '03' =>  'tifmCOMPRAS',
            '04' =>  'tifmCJ',
            '05' =>  'tifmCONT',
            '06' =>  'tifmCTIM',
            '07' =>  'tifmDGD',
            '08' =>  'tifmDA',
            '09' =>  'tifmDGC',
            '10' =>  'tifmDP',
            '11' =>  'tifmDPCAD',
            '12' =>  'tifmDTH',
            '13' =>  'tifmDTI',
            '14' =>  'tifmFAIM',
            '15' =>  'tifmFIMIM',
            '16' =>  'tifmSASP',
            '17' =>  'tifmSC',
            '18' =>  'tifmSIP',
            '19' =>  'tifmSPSC',
            '20' =>  'tifmSPS',
            '21' =>  'tifmSS',
            '22' =>  'tifmSAIM',
            '23' =>  'tifmSATIM',
            '24' =>  'tifmTESO'
        ];
        $password = [
            '01'  =>  'AItifm',
            '02'  =>  'BNtifm',
            '03'  =>  'COMPRAStifm',
            '04'  =>  'CJtifm',
            '05'  =>  'CONTtifm',
            '06'  =>  'CTIMtifm',
            '07'  =>  'DGDtifm',
            '08'  =>  'DAtifm',
            '09'  =>  'DGCtifm',
            '10'  =>  'DPtifm',
            '11'  =>  'DPCADtifm',
            '12'  =>  'DTHtifm',
            '13'  =>  'DTItifm',
            '14'  =>  'FAIMtifm',
            '15'  =>  'FIMIMtifm',
            '16'  =>  'SASPtifm',
            '17'  =>  'SCtifm',
            '18'  =>  'SIPtifm',
            '19'  =>  'SPSCtifm',
            '20'  =>  'SPStifm',
            '21'  =>  'SStifm',
            '22'  =>  'SAIMtifm',
            '23'  =>  'SATIMtifm',
            '24'  =>  'TESOtifm'
        ];

        // ASIGNA PERMISO ESPECIAL A USUARIO DESPACHO
        $auth = Yii::$app->authManager;

        foreach ($personal as $clave => $valor) {
            $user = new Usuario;
            $user->username = $valor;
            $user->generateAuthKey();
            $user->password = $password[$clave];
            $user->generatePasswordResetToken();
            $user->email = $valor.'tifm@tifm.com';
            $user->status = 1;
            $user->created_at = date( "Y-m-d h:i:s",time() );
            $user->generateEmailVerificationToken();
            $user->fkdepart = $clave;
            if ( $user->save(false) ) {
                $personalrole = $auth->getRole('personal');
                $auth->assign($personalrole, $user->getId());
                if ( $user->getId() === 9 ) {
                    $Roledespacho = $auth->getRole('despacho');
                    $auth->assign( $Roledespacho, $user->getId() );
                }
            }
        }
    }//

    public function actionReiniciartablas()
    {
        //$restart = new Connection;
        $command = Yii::$app->db->createCommand('TRUNCATE TABLE public.auth_assignment RESTART IDENTITY CASCADE');
        $command->execute();
        $command = Yii::$app->db->createCommand('TRUNCATE TABLE public.auth_item RESTART IDENTITY CASCADE');
        $command->execute();
        $command = Yii::$app->db->createCommand('TRUNCATE TABLE public.auth_item_child RESTART IDENTITY CASCADE');
        $command->execute();
        $command = Yii::$app->db->createCommand('TRUNCATE TABLE public.auth_rule RESTART IDENTITY CASCADE');
        $command->execute();
        $command = Yii::$app->db->createCommand('TRUNCATE TABLE comedor.invitado RESTART IDENTITY CASCADE');
        $command->execute();
        $command = Yii::$app->db->createCommand('TRUNCATE TABLE comedor.usuario RESTART IDENTITY CASCADE');
        $command->execute();
        $command = Yii::$app->db->createCommand('TRUNCATE TABLE comedor.personal RESTART IDENTITY CASCADE');
        $command->execute();
        $command = Yii::$app->db->createCommand('TRUNCATE TABLE comedor.departamento RESTART IDENTITY CASCADE');
        $command->execute();
        $command = Yii::$app->db->createCommand('TRUNCATE TABLE comedor.perscomedor RESTART IDENTITY CASCADE');
        $command->execute();
    }
}


?>
