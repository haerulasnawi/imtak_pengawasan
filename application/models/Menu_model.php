<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    public function getSubMenu()
    {
        $query = "SELECT `user_sub_menu`.*,`user_menu`.`menu`
                    FROM `user_sub_menu` JOIN `user_menu`
                    ON `user_sub_menu`.`menu_id` = `user_menu`.`id`";

        return $this->db->query($query)->result_array();
    }

    function ubah($data)
    {

        $this->db->replace('user_menu', $data);
        return $this;
    }

    public function getDataUbah($id)
    {
        $query = " SELECT * FROM `user_menu` WHERE `id`=$id";
        return $this->db->query($query)->row();
    }

    public function deleteMenu($id)
    {

        $this->db->delete('user_menu', array('id' => $id));

        return $this->db->affected_rows();
    }

    public function deleteUser($id)
    {

        $this->db->delete('user', array('id' => $id));

        return $this->db->affected_rows();
    }

    public function getFreelance()
    {
        $query = "SELECT `freelance`.*,`user`.`email`
                    FROM `freelance` JOIN `user`
                    ON `freelance`.`email` = `user`.`email`
                    WHERE `user`.`role_id` = 2";

        return $this->db->query($query)->result_array();
    }

    public function deleteFreelance($id)
    {

        $this->db->delete('freelance', array('id' => $id));

        return $this->db->affected_rows();
    }

    public function deleteSubm($id)
    {

        $this->db->delete('user_sub_menu', array('id' => $id));

        return $this->db->affected_rows();
    }

    function ubahsub($data)
    {
        $this->db->replace('user_sub_menu', $data);
        return $this;
    }

    public function getDataUbahSub($id)
    {
        $query = " SELECT * FROM `user_sub_menu` WHERE `id`=$id";
        return $this->db->query($query)->row();
    }

    function ubahfree($data)
    {
        $this->db->replace('freelance', $data);
        return $this;
    }

    public function getDataUbahFree($id)
    {
        $query = " SELECT * FROM `freelance` WHERE `id`=$id";
        return $this->db->query($query)->row();
    }
}
