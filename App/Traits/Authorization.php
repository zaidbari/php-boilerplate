<?php

namespace App\Traits;

trait Authorization
{
    use Logs, Request;

    private ?array $_set_role = null;

    protected function role( array $set ) : static
    {
        $this->_set_role = $set;
        return $this;
    }

    protected function authorize( int $check_user = null )
    {
        if (!isset($_SESSION['user']) ) {
            $this->log('info', 'Unauthorized attempt to access ' . $this->getRequestPath());
            $this->redirect('/login');
        } 
    }


    protected function user()
    {
        return $_SESSION['user'];
    }

}
