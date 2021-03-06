<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "privilegio".
 *
 * @property int $id
 * @property int $id_usuario
 * @property int $crear_habitacion
 * @property int $modificar_habitacion
 * @property int $eliminar_habitacion
 * @property int $crear_tipo_habitacion
 * @property int $modificar_tipo_habitacion
 * @property int $eliminar_tipo_habitacion
 * @property int $movimientos_caja
 * @property int $apertura_caja
 * @property int $cierre_caja
 * @property int $crear_huesped
 * @property int $modificar_huesped
 * @property int $eliminar_huesped
 * @property int $crear_reservacion
 * @property int $modificar_reservacion
 * @property int $eliminar_reservacion
 * @property int $descuento
 * @property int $crear_tarifa
 * @property int $modificar_tarifa
 * @property int $eliminar_tarifa
 * @property int $crear_origen
 * @property int $modificar_origen
 * @property int $eliminar_origen
 * @property int $crear_usuario
 * @property int $modificar_usuario
 * @property int $eliminar_usuario
 * @property int $definir_privilegios
 */
class Privilegio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'privilegio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario', 'crear_habitacion', 'modificar_habitacion', 'eliminar_habitacion', 'crear_tipo_habitacion', 'modificar_tipo_habitacion', 'eliminar_tipo_habitacion', 'crear_huesped', 'modificar_huesped', 'eliminar_huesped', 'crear_reservacion', 'modificar_reservacion', 'eliminar_reservacion', 'descuento', 'crear_tarifa', 'modificar_tarifa', 'eliminar_tarifa', 'crear_origen', 'modificar_origen', 'eliminar_origen','crear_usuario','modificar_usuario','eliminar_usuario','definir_privilegios'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_usuario' => Yii::t('app', 'Id Usuario'),
            'crear_habitacion' => Yii::t('app', 'Crear Habitacion'),
            'modificar_habitacion' => Yii::t('app', 'Modificar Habitacion'),
            'eliminar_habitacion' => Yii::t('app', 'Eliminar Habitacion'),
            'crear_tipo_habitacion' => Yii::t('app', 'Crear Tipo Habitacion'),
            'modificar_tipo_habitacion' => Yii::t('app', 'Modificar Tipo Habitacion'),
            'eliminar_tipo_habitacion' => Yii::t('app', 'Eliminar Tipo Habitacion'),
            'movimientos_caja' => Yii::t('app', 'Movimientos de Caja'),
            'apertura_caja' => Yii::t('app', 'Apertura de Caja'),
            'cierre_caja' => Yii::t('app', 'Cierre de Caja'),
            'crear_huesped' => Yii::t('app', 'Crear Huesped'),
            'modificar_huesped' => Yii::t('app', 'Modificar Huesped'),
            'eliminar_huesped' => Yii::t('app', 'Eliminar Huesped'),
            'crear_reservacion' => Yii::t('app', 'Crear Reservacion'),
            'modificar_reservacion' => Yii::t('app', 'Modificar Reservacion'),
            'eliminar_reservacion' => Yii::t('app', 'Eliminar Reservacion'),
            'descuento' => Yii::t('app', 'Descuento'),
            'realizar_pago' => Yii::t('app', 'Realizar Pago'),
            'crear_tarifa' => Yii::t('app', 'Crear Tarifa'),
            'modificar_tarifa' => Yii::t('app', 'Modificar Tarifa'),
            'eliminar_tarifa' => Yii::t('app', 'Eliminar Tarifa'),
            'crear_origen' => Yii::t('app', 'Crear Origen'),
            'modificar_origen' => Yii::t('app', 'Modificar Origen'),
            'eliminar_origen' => Yii::t('app', 'Eliminar Origen'),
            'crear_usuario' => Yii::t('app', 'Crear Usuario'),
            'modificar_usuario' => Yii::t('app', 'Modificar Usuario'),
            'eliminar_usuario' => Yii::t('app', 'Eliminar Usuario'),
            'definir_privilegios' => Yii::t('app', 'Definir Privilegios'),
        ];
    }
}
