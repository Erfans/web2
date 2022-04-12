<?php
/**
 * codekunst GmbH <www.codekunst.com>
 * @author e <hello@codekunst.com>
 */

namespace App\Listener;


use Symfony\Component\HttpKernel\Event\RequestEvent;

class KernelListener
{

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        $request->setLocale("fa");
    }

}