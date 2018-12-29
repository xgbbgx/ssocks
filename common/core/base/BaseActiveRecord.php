<?php
namespace common\core\base;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

class BaseActiveRecord extends ActiveRecord{
    const DATAFIX_DELETE = 1;//删除
    const DATAFIX = 0;
    /**
     * 
     * @param unknown $select
     * @param unknown $where
     * @param unknown $isArray
     * @return \yii\db\ActiveRecord|array|NULL
     */
    public static function getOne($select,$where,$order='',$isArray=true){
        $query = self::find()->select($select)->where($where)->orderBy($order);
        if ($isArray) {
            $query->asArray();
        }
        return $query->one();
    
    }
   /**
    * 
    * @param unknown $select
    * @param unknown $where
    * @param string $order
    * @param string $isArray
    * @return array|\yii\db\ActiveRecord[]
    */
    public static function getAll($select,$where,$order='',$isArray=true){
        $query = self::find()->select($select)->where($where)->orderBy($order);
        if ($isArray) {
            $query->asArray();
        }
        return $query->all();
        
    }
    /**
     *
     * {@inheritDoc}
     * @see \yii\db\BaseActiveRecord::beforeSave()
     */
    public function beforeSave($insert){
        $uid=Yii::$app->user->getId();
        
        if ($insert) {
            if($this->hasProperty('created_at') ){
                $this->created_at = new Expression('UNIX_TIMESTAMP()') ;
            }
            if($this->hasProperty('created_by')){
                $this->created_by = $uid ?: 0;
            }
        }else{
            if($this->hasProperty('updated_at')){
                $this->updated_at = new Expression('UNIX_TIMESTAMP()');
            }
            if($this->hasProperty('updated_by')){
                $this->updated_by = $uid ?: 0;
            }
        }
        
        return parent::beforeSave($insert);
    }
}