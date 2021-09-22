<?php

namespace Illuminate\Foundation\Auth;

trait RedirectsUsers
{
    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        if($this->redirectTo === ''){
            return url()->previous();
        }

        return $this->redirectTo;

    }
}
