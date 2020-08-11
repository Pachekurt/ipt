<?php

/*$options = array(
    'delete_type' => 'POST',
    'db_host' => 'localhost',
    'db_user' => 'root',
    'db_pass' => '123',
    'db_name' => 'duartema_nacional',
    'db_table' => 'fotos'
);*/

$options = array(
    'delete_type' => 'POST',
    'db_host' => 'localhost',
    'db_user' => 'duartema_admin',
    'db_pass' => 'Jhulios20005',
    'db_name' => 'duartema_nacional',
    'db_table' => 'fotos'
);
error_reporting(E_ALL | E_STRICT);
require('UploadHandler.php');

class CustomUploadHandler extends UploadHandler {

    protected function initialize() {
        $this->db = new mysqli(
            $this->options['db_host'],
            $this->options['db_user'],
            $this->options['db_pass'],
            $this->options['db_name']
        );
        parent::initialize();
        $this->db->close();
    }

    protected function handle_form_data($file, $index) {
        $file->title = @$_REQUEST['titulo'][$index];
        $file->description = @$_REQUEST['description'][$index];
        $file->url_proc = @$_REQUEST['url_proc'][$index];

        $file->url_ubicacion = @$_SERVER['PHP_SELF'];
        $file->id_usuario = @$_REQUEST['id_usuario'][$index];
        $file->tipo_foto = @$_REQUEST['tipo_foto'][$index];

        $file->fecha_creacion = date('Y-m-d');
        $file->tipo_usuario = @$_REQUEST['tipo_usuario'][$index];
        $file->id_publicacion = @$_REQUEST['id_publicacion'][$index];
        $file->principal = @$_REQUEST['principal'][$index];
        $file->hora_creacion = date("H:i:s");

    }

    protected function handle_file_upload($uploaded_file, $name, $size, $type, $error,
            $index = null, $content_range = null) {
        $file = parent::handle_file_upload(
            $uploaded_file, $name, $size, $type, $error, $index, $content_range
        );
        if (empty($file->error)) {
            $sql = 'INSERT INTO `'.$this->options['db_table']
                .'` (`name`, `size`, `type`, `url_procedencia`, `url_ubicacion`, `title`, `description`,`usuariocreacion`,
                    `tipo_foto`  ,`fecha_creacion`,`tipo_usuario`,`id_publicacion`,`principal`,`hora_creacion`)'
                .' VALUES (?, ?, ?, ?,?, ?, ?, ?,?,?,?,?,?,?)';
            $query = $this->db->prepare($sql);
            $query->bind_param(
                'sissssssssssss',
                $file->name,
                $file->size,
                $file->type,

                $file->url_proc,
                $file->url_ubicacion,
                $file->title,

                $file->description,
                $file->id_usuario,
                $file->tipo_foto,

                $file->fecha_creacion,
                $file->tipo_usuario,
                $file->id_publicacion,
                $file->principal,
                $file->hora_creacion

            );
            $query->execute();
            $file->id = $this->db->insert_id;
        }
        return $file;
    }

    protected function set_additional_file_properties($file) {
        parent::set_additional_file_properties($file);
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $sql = 'SELECT `idfotos`, `type`, `title`, `description` FROM `'
                .$this->options['db_table'].'` WHERE `name`=?';
            $query = $this->db->prepare($sql);
            $query->bind_param('s', $file->name);
            $query->execute();
            $query->bind_result(
                $id,
                $type,
                $title,
                $description
            );
            while ($query->fetch()) {
                $file->id = $id;
                $file->type = $type;
                $file->title = $title;
                $file->description = $description;
            }
        }
    }

    public function delete($print_response = true) {
        $response = parent::delete(false);
        foreach ($response as $name => $deleted) {
            if ($deleted) {
                $sql = 'DELETE FROM `'
                    .$this->options['db_table'].'` WHERE `name`=?';
                $query = $this->db->prepare($sql);
                $query->bind_param('s', $name);
                $query->execute();
            }
        }
        return $this->generate_response($response, $print_response);
    }

}

$upload_handler = new CustomUploadHandler($options);
