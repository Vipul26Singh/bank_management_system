<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('value_exists'))
{
    function value_exists($table,$col,$value,$id='',$id_value='')
    {
        $CI	=&	get_instance();
		$CI->load->database();
        $rowcount=0;
        
        if($id=='' && $id_value==''){
        $CI->db->select($col);
        $CI->db->from($table);
        $CI->db->where($col,$value);
		$CI->db->where('member_id',$value);
        $query=$CI->db->get();
        $rowcount = $query->num_rows();
        }else{
        $CI->db->select($col);
        $CI->db->from($table);
        $CI->db->where($col,$value);
		$CI->db->where('member_id',$value);
        $CI->db->where_not_in($id,$id_value);    
        $query=$CI->db->get();
        $rowcount = $query->num_rows();
        
        }
            
        if($rowcount>0){
        return true;
        }else{
        return false;
        }
        
    }  

        function value_exists2($table,$col,$value,$type,$type_value,$id='',$id_value='')
    {
        $CI =&  get_instance();
        $CI->load->database();
        $rowcount=0;
        
        if($id=='' && $id_value==''){
        $CI->db->select($col);
        $CI->db->from($table);
        $CI->db->where($col,$value);
		$CI->db->where('user_id',$CI->session->userdata('user_id'));
        $CI->db->where($type,$type_value); 
        $query=$CI->db->get();
        $rowcount = $query->num_rows();
        }else{
        $CI->db->select($col);
        $CI->db->from($table);
        $CI->db->where($col,$value);
        $CI->db->where($type,$type_value); 
		$CI->db->where('user_id',$CI->session->userdata('user_id'));
        $CI->db->where_not_in($id,$id_value);    
        $query=$CI->db->get();
        $rowcount = $query->num_rows();
        
        }
            
        if($rowcount>0){
        return true;
        }else{
        return false;
        }
        
    } 
    function value_exists3($table,$col,$value,$id='',$id_value='')
    {
        $CI =&  get_instance();
        $CI->load->database();
        $rowcount=0;
        
        if($id=='' && $id_value==''){
        $CI->db->select($col);
        $CI->db->from($table);
        $CI->db->where($col,$value);
        $query=$CI->db->get();
        $rowcount = $query->num_rows();
        }else{
        $CI->db->select($col);
        $CI->db->from($table);
        $CI->db->where($col,$value);
        $CI->db->where_not_in($id,$id_value);    
        $query=$CI->db->get();
        $rowcount = $query->num_rows();
        
        }
            
        if($rowcount>0){
        return true;
        }else{
        return false;
        }
        
    } 
    function value_exists4($table,$col,$id='',$id_value='')
    {
    $CI =&  get_instance();
        $CI->load->database();
        $rowcount=0;
        
        if($id_value==''){
        $CI->db->select($col);
        $CI->db->from($table);
        $array = ['member_id'=>$id,'taken'=>0];
        $CI->db->where($array);
        $CI->db->order_by('date','desc');
        $query=$CI->db->get();
        $rowcount = $query->num_rows();
        }else{
            $rowcount = 0;
        }
            
        if($rowcount>0){
        return false;
        }else{
        return true;
        }
        
    }
    function value_exists5($table,$col,$id='',$id_value='')
    {
    $CI =&  get_instance();
        $CI->load->database();
        $rowcount=0;
        
        if($id_value==''){
        $CI->db->select($col);
        $CI->db->from($table);
        $array = ['member_id'=>$id];
        $CI->db->where($array);
        $query=$CI->db->get();
        $rowcount = $query->num_rows();
        }else{
            $rowcount = 0;
        }
            
        if($rowcount>0){
        return false;
        }else{
        return true;
        }
        
    }
    function value_exists6($table,$col,$id='',$loan_id='',$paid='')
    {
    $CI =&  get_instance();
        $CI->load->database();
        $rowcount=0;
        
        
        $CI->db->select($col);
        $CI->db->from($table);
        $array = ['member_id'=>$id,'paid='=>$paid];
        $CI->db->where($array);
        $query=$CI->db->get();
        $rowcount = $query->num_rows();
    
       
        if($rowcount>0){
        return true;
        }else{
        return false;
        }
        
    }


}