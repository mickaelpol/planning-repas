<?php


namespace AppBundle\Listeners;


use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Translation\TranslatorInterface;

class AfterLoginNotif extends Controller implements AuthenticationSuccessHandlerInterface
{

    private $router;
    private $em;
    private $translator;
    private $flashBag;

    public function __construct(ObjectManager $em, RouterInterface $router, TranslatorInterface $translator, FlashBagInterface $flashBag)
    {
        $this->router = $router;
        $this->em = $em;
        $this->translator = $translator;
        $this->flashBag = $flashBag;
    }

    /**
     * This is called when an interactive authentication attempt succeeds. This
     * is called by authentication listeners inheriting from
     * AbstractAuthenticationListener.
     *
     * @param Request $request
     * @param TokenInterface $token
     * @return RedirectResponse never null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {

        $user = $token->getUsername();
        $this->flashBag->add(
            'success',
            $this->translator->trans('reconnected.user', ['user' => $user])
        );

        $route = $this->router->generate('homepage');
        $redirect = new RedirectResponse($route);

        return $redirect;

    }
}