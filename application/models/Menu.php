<?php
class Menu extends CI_Model
{
    function edit_menu($id_menu, $menu)
    {
        $hasil = $this->db->query("UPDATE user_menu SET menu = '$menu' WHERE id ='$id_menu'");
        return $hasil;
    }

    function delete_menu($id_menu, $menu)
    {
        $hasil = $this->db->query("");
    }
}
