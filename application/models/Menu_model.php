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

    function ubah($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('menu', $data);
        return TRUE;
    }

    public function getDataUbah($id)
    {
        $query = " SELECT * FROM `user_menu` WHERE `id`=$id";
        return $this->db->query($query)->row();
    }
}
