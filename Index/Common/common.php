<?php
/**
 * 返回某个栏目下所有子栏目以及本身的所有热卖或推荐商品的id
 * @param type $cid
 * @param type $type
 * @return type
 */
 function check_cate_hot_goods($cid,$type='hot'){
      $cid_arr =check_all_cate($cid);
      $allarr = array();
      foreach ($cid_arr as $v) {
            $arr =get_all_cate_hg($v,$type);
            foreach ($arr as $value) {
                  if(count($value['id']) && !in_array($value['id'], $allarr)){
                     $allarr[]=$value['id'];
                 }
            }

      }
      return $allarr;
 }
 /**
  * 获得该栏目下的热卖商品
  * @param type $cid
  */
 function get_all_cate_hg($cid,$type='hot'){
     $arr =array();
     $db=M('goods');
     $data = $db->where(array('cid'=>$cid,$type=>1))->field('id')->select();
     return $data;
 }
       /**
        * 获得所有子栏目的id
        */
   function check_all_cate($cid){
       static $arr = array();
       $arr[] = $cid;
       $db = M('category');
       $data = $db ->where(array('pid'=>$cid))->select();
       if(count($data)){
       foreach($data as $v){
               $arr[] = $v['id'];
          }
          return $arr;
       }else{
           return $arr;
       }
   }
   /**
    * 打印函数
    * @param type $arr
    */
   function p($arr){
       echo "<pre>";
       print_r($arr);
   }

   /**
    * 格式化商品页商品信息
    * @param type $arr
    * @return type
    */
     function format_goods($arr){
         $data = array();
         foreach($arr[0] as $k=>$v){
             if($k!= 'attr_price' && $k!='attr_id' && $k!='attr_name' && $k!='value' && $k!='type' && $k!='attrid' && $k!='in_id' && $k!='inventory' && $k!='attr_com' && $k!='in_number' && $k!='series' && $k!='in_price'){
                 if($k == 'mini' || $k=='medium' || $k=='max'){
                     $data[$k]=  explode('|', $v);
                 }else{
                     $data[$k]=$v;
                 }
             }
         }
         $attrs = array();
         $specs = array();
         foreach ($arr as $key => $value) {
             if($value['type']==0 && count($attrs[$value['attrid']])==0){
               $attr=array();
               $attr['attr_id']=$value['attr_id'];
               $attr['attr_price']=$value['attr_price'];
               $attr['attr_name']=$value['attr_name'];
               $attr['value']=$value['value'];
               $attr['attrid']=$value['attrid'];
               $attr['type']=$value['type'];
               $attrs[$value['attrid']]=$attr;
             }else if($value['type']==1 && count($specs[$value['attrid']])==0){
                 $spec=array();
                 $spec['attr_id']=$value['attr_id'];
                 $spec['attr_price']=$value['attr_price'];
                 $spec['attr_name']=$value['attr_name'];
                 $spec['value']=$value['value'];
                 $spec['attrid']=$value['attrid'];
                 $spec['type']=$value['type'];
                 $specs[$value['attrid']]=$spec;
             }
         }
         $data['attrs']=$attrs;
         $specs = format_arr($specs);
         $data['specs']=$specs;
         $data['inven']=format_inven($arr);
         return $data;
}
/**
 * 格式化库存以及套餐信息
 * @param type $arr
 * @return type
 */
function format_inven($arr){
    $farr = array();
    foreach ($arr as $v) {
           $farr[$v['in_id']]=array();
      }
    foreach ($farr as $key => $value) {
          foreach ($arr as $val) {
              if($val['in_id']==$key && count($value)==0){
                  $farr[$key]['in_id']=$val['in_id'];
                  $farr[$key]['inventory']=$val['inventory'];
                  $farr[$key]['attr_com']=$val['attr_com'];
                  $farr[$key]['in_number']=$val['in_number'];
                  $farr[$key]['series']=$val['series'];
                  $farr[$key]['in_price']=$val['in_price'];
              }
          }
      }
      return $farr;
}
/**
 * 格式化规格的信息
 * @param type $arr
 * @return type
 */
  function format_arr($arr){
      $farr = array();
      foreach ($arr as $v) {
           $farr[$v['attr_id']]=array();
      }
      foreach ($farr as $key => $value) {
          foreach ($arr as $val) {
              if($val['attr_id']==$key && count($farr[$key][$val['attrid']])==0){
                  $farr[$key][$val['attrid']]=$val;
              }
          }
      }
      return $farr;
  }
 /**
  * 获得商品的信息
  * @param type $gid
  * @return type
  */

  function get_goods_mes($gid){
       $db = D('GoodsView');
       $date = $db->where(array("gid"=>$gid))->select();
       $mes = format_goods($date);
       return $mes;
  }
 function get_spec_name($arr){
         $arrs =array();
      foreach ($arr as $key => $value) {
          $arr =array();
          $arr['attr_id']=$key;
          $arr['attr_name']=$value[0]['attr_name'];
          $arrs[]=$arr;
     }
       return $arrs;
 }

?>