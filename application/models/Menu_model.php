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

    public function deleteRole($id)
    {

        $this->db->delete('user_role', array('id' => $id));

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

    public function getPegawai()
    {
        $query = "SELECT * FROM `user` WHERE `role_id` = 2";

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

    public function gettasks()
    {
        $query = "SELECT `request_task`.*,`freelance`.`name`,`freelance`.`email`
                    FROM `request_task` JOIN `freelance`
                    ON `request_task`.`id_freelance` = `freelance`.`id`";

        return $this->db->query($query)->result_array();
    }

    public function deleteTask($id)
    {

        $this->db->delete('request_task', array('id' => $id));

        return $this->db->affected_rows();
    }

    function ubahtask($data)
    {
        $this->db->replace('request_task', $data);
        return $this;
    }

    public function getDataUbahTask($id)
    {
        $query = " SELECT * FROM `request_task` WHERE `id`=$id";
        return $this->db->query($query)->row();
    }

    function ubahrole($data)
    {
        $this->db->replace('user_role', $data);
        return $this;
    }

    public function getDataUbahRole($id)
    {
        $query = " SELECT * FROM `user_role` WHERE `id`=$id";
        return $this->db->query($query)->row();
    }

    public function gettasksinvoice()
    {
        $query = "SELECT `task_invoice`.*,`request_task`.`task_files`
                    FROM `task_invoice` JOIN `request_task`
                    ON `task_invoice`.`id_reqtask` = `request_task`.`id`";
        return $this->db->query($query)->result_array();
    }

    public function deleteTaskInvoice($id)
    {

        $this->db->delete('task_invoice', array('id' => $id));

        return $this->db->affected_rows();
    }

    public function getdataInvoice()
    {
        $query = "SELECT `invoice`.*,`task_invoice`.`date_created`
                    FROM `invoice` JOIN `task_invoice`
                    ON `invoice`.`id_task_reqtask` = `task_invoice`.`id`";
        return $this->db->query($query)->result_array();
    }

    public function deleteInvoice($id)
    {

        $this->db->delete('invoice', array('id' => $id));

        return $this->db->affected_rows();
    }

    public function deleteEvent($id)
    {

        $this->db->delete('event', array('id' => $id));

        return $this->db->affected_rows();
    }

    public function deletepengumuman($id)
    {

        $this->db->delete('informasi', array('id' => $id));

        return $this->db->affected_rows();
    }

    public function approvalEvent($id)
    {
        $query = "UPDATE `event` SET `status`='disetujui' WHERE `id`=$id";

        return $this->db->query($query);
    }
}
