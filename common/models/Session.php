<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "session".
 *
 * @property int $id
 * @property string $hour
 * @property string $date
 * @property int $movie_id
 * @property int $room_id
 * @property int $created_at
 *
 * @property Room $room
 * @property Movie $movie
 * @property Ticket[] $tickets
 */
class Session extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%session}}';
    }
    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hour', 'date'], 'safe'],
            [['movie_id', 'room_id', 'created_at'], 'integer'],
            [['created_at'], 'required'],
            [['room_id'], 'exist', 'skipOnError' => true, 'targetClass' => Room::className(), 'targetAttribute' => ['room_id' => 'id']],
            [['movie_id'], 'exist', 'skipOnError' => true, 'targetClass' => Movie::className(), 'targetAttribute' => ['movie_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hour' => 'Hora',
            'date' => 'Data',
            'movie_id' => 'ID do Filme',
            'room_id' => 'ID da Sala',
            'created_at' => 'Data de Criação',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoom()
    {
        return $this->hasOne(Room::className(), ['id' => 'room_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMovie()
    {
        return $this->hasOne(Movie::className(), ['id' => 'movie_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['session_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return SessionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SessionQuery(get_called_class());
    }
}
