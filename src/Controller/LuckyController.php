<?php
/**
 * codekunst GmbH <www.codekunst.com>
 * @author ES <hello@codekunst.com>
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LuckyController extends AbstractController
{
    /**
     * @Route(path="/lucky/number",methods={"GET"})
     *
     * @return Response
     * @throws \Exception
     */
    public function number(): Response
    {
        $number = random_int(0, 100);
        return $this->render('lucky/number.html.twig', [
            'number' => $number,
        ]);
    }
}