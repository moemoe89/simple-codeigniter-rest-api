<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Guayaquil');
class MyModel extends CI_Model {

    var $client_service = "frontend-client";
    var $auth_key       = "simplerestapi";

    public function check_auth_client(){
        $client_service = $this->input->get_request_header('Client-Service', TRUE);
        $auth_key  = $this->input->get_request_header('Auth-Key', TRUE);
        if($client_service == $this->client_service && $auth_key == $this->auth_key){
            return true;
        } else {
            return json_output(401,array('status' => 401,'message' => 'Unauthorized.'));
        }
    }

    public function login($username,$password)
    {
        $q  = $this->db->select('password,id')->from('users')->where('username',$username)->get()->row();
        if($q == ""){
            return array('status' => 204,'message' => 'Username not found.');
        } else {
            $hashed_password = $q->password;
            $id              = $q->id;
            if (hash_equals($hashed_password, crypt($password, $hashed_password))) {
                $obj_ua  = $this->db->from('users_authentication')->where('users_id',$q->id)->where('estado = 1')->get();
                
                $last_login = date('Y-m-d H:i:s');
                
                if($obj_ua->num_rows() > 0){
                    $ua=$obj_ua->row();
                    //print_r($ua);
                    //echo "<br/>".$last_login;
                    //echo "<br/>".$ua->expired_at;
                    if(strtotime($last_login) <= strtotime($ua->expired_at) ){
                        return array('status' => 200,'message' => 'Token was generated which expires on '.$ua->expired_at,'user' => $username, 'token' => $ua->token);
                    }else{
                        $this->db->where('users_id',$id)->update('users_authentication',array('estado' => 0));
                        $token = crypt(substr( md5(rand()), 0, 7),'$5$rounds=5000$fragatausesystringforsalt$');
                        echo $expired_at = date("Y-m-d H:i:s", strtotime('+12 hours'));
                        $this->db->trans_start();
                        $this->db->where('id',$id)->update('users',array('last_login' => $last_login));
                        $this->db->insert('users_authentication',array('users_id' => $id,'token' => $token,'expired_at' => $expired_at));
                        if ($this->db->trans_status() === FALSE){
                            $this->db->trans_rollback();
                            return array('status' => 500,'message' => 'Internal server error.');
                        } else {
                            $this->db->trans_commit();
                            return array('status' => 200,'message' => 'Successfully login.','user' => $username, 'token' => $token);
                        }
                    }                    
                }else{   
                    $token = crypt(substr( md5(rand()), 0, 7),'$5$rounds=5000$fragatausesystringforsalt$');
                    $expired_at = date("Y-m-d H:i:s", strtotime('+12 hours'));
                    $this->db->trans_start();
                    $this->db->where('id',$id)->update('users',array('last_login' => $last_login));
                    $this->db->insert('users_authentication',array('users_id' => $id,'token' => $token,'expired_at' => $expired_at));
                    if ($this->db->trans_status() === FALSE){
                        $this->db->trans_rollback();
                        return array('status' => 500,'message' => 'Internal server error.');
                    } else {
                        $this->db->trans_commit();
                        return array('status' => 200,'message' => 'Successfully login.','user' => $username, 'token' => $token);
                    }
                }
            } else {
               return array('status' => 204,'message' => 'Wrong password.');
            }
        }
    }

    public function logout()
    {
        $users_id  = $this->input->get_request_header('User', TRUE);
        $token     = $this->input->get_request_header('Authorization', TRUE);
        $this->db->where('users_id',$users_id)->where('token',$token)->delete('users_authentication');
        return array('status' => 200,'message' => 'Successfully logout.');
    }

    public function auth()
    {
        $user  = $this->input->get_request_header('User', TRUE);
        $token     = $this->input->get_request_header('Authorization', TRUE);
        $o  = $this->db->select('id')->from('users')->where('username',$user)->get()->row();
        $q  = $this->db->select('expired_at')->from('users_authentication')->where('users_id',$o->id)->where('token',$token)->get()->row();
        if($q == ""){
            return json_output(401,array('status' => 401,'message' => 'Unauthorized.'));
        } else {
            if(strtotime($q->expired_at) < strtotime(date('Y-m-d H:i:s'))){echo $q->expired_at ."<br/>".date('Y-m-d H:i:s');
                return json_output(401,array('status' => 401,'message' => 'Your session has been expired.'));
            } else {
                $updated_at = date('Y-m-d H:i:s');
                $expired_at = date("Y-m-d H:i:s", strtotime('+12 hours'));
                $this->db->where('users_id',$o->id)->where('token',$token)->update('users_authentication',array('expired_at' => $expired_at,'updated_at' => $updated_at));
                return array('status' => 200,'message' => 'Authorized.');
            }
        }
    }

    public function book_all_data()
    {
        return $this->db->select('id,title,author')->from('books')->order_by('id','desc')->get()->result();
    }

    public function book_detail_data($id)
    {
        return $this->db->select('id,title,author')->from('books')->where('id',$id)->order_by('id','desc')->get()->row();
    }

    public function book_create_data($data)
    {
        $this->db->insert('books',$data);
        return array('status' => 201,'message' => 'Data has been created.');
    }

    public function book_update_data($id,$data)
    {
        $this->db->where('id',$id)->update('books',$data);
        return array('status' => 200,'message' => 'Data has been updated.');
    }

    public function book_delete_data($id)
    {
        $this->db->where('id',$id)->delete('books');
        return array('status' => 200,'message' => 'Data has been deleted.');
    }

}
