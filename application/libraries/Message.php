<?php

class Message
{
    public function success($output = null)
    {
        $success = array(
            'success' => 0,
        );
        if (is_array($output)) {
            foreach ($output as $key => $value) {
                $success[$key] = $value;
            }
        } elseif (is_string($output)) {
            $success['message'] = $output;
        } elseif (is_numeric($output)) {
            $success['success'] = $output;
        }

        echo json_encode($success);
        exit();
    }

    public function error($output = null)
    {
        $error = array(
            'error' => 0,
        );
        if (is_array($output)) {
            foreach ($output as $key => $value) {
                $error[$key] = $value;
            }
        } elseif (is_string($output)) {
            $error['message'] = $output;
        } elseif (is_numeric($output)) {
            $error['error'] = $output;
        }

        echo json_encode($error);
        exit();
    }
}
