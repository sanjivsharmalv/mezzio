<?php

declare(strict_types=1);

namespace App\Login;

use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Plates\PlatesRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;

class LoginHandler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private ?TemplateRendererInterface $template = null;

    public function __construct(TemplateRendererInterface $template)
    {
        $this->template = $template;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $data = [];

        if ($this->template === null) {
            return new JsonResponse([
                    'welcome' => 'Congratulations! You have installed the mezzio skeleton application.',
                    'docsUrl' => 'https://docs.mezzio.dev/mezzio/',
                ] + $data);
        }

        if ($this->template instanceof PlatesRenderer) {
            $data['templateName'] = 'Plates';
            $data['templateDocs'] = 'https://platesphp.com/';
        } elseif ($this->template instanceof TwigRenderer) {
            $data['templateName'] = 'Twig';
            $data['templateDocs'] = 'https://twig.symfony.com';
        } elseif ($this->template instanceof LaminasViewRenderer) {
            $data['templateName'] = 'Laminas View';
            $data['templateDocs'] = 'https://docs.laminas.dev/laminas-view/';
        }

        return new HtmlResponse($this->template->render('app::login', $data));
        // Do some work...
        // Render and return a response:
       /* return new HtmlResponse($this->renderer->render(
            'app::login',
            [] // parameters to pass to template
        ));*/
    }
}
