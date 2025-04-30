<?php
    class ResponseHandler {
        public static function success($data = null, $message = 'Operación exitosa') {
            echo json_encode([
                'result' => '1',
                'message' => $message,
                'payload' => $data
            ]);
            exit;
        }

        public static function error($message = 'Error en la operación') {
            echo json_encode([
                'result' => '0',
                'message' => $message,
                'payload' => null
            ]);
            exit;
        }
    }
?>