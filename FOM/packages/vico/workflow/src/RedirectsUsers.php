<?php

namespace Vico\Workflow;

trait RedirectsUsers
{
    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        if(isset($_COOKIE['isCreatingHouse'])) {
            $myItem = $_COOKIE['isCreatingHouse'];
            if($myItem == 'true'){
                return $this->redirectTo = route('create_house', 1);
            }
        }
        if($this->redirectTo === ''){
            return url()->previous();
        }

        return $this->redirectTo;

    }
}
