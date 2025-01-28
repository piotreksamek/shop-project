<?php

declare(strict_types=1);

namespace App;

use App\Shared\Redis\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsController]
class HomeController extends AbstractController
{
    public function __construct(
        private readonly TagAwareCacheInterface $tagAwareCache,
        private readonly CacheInterface $cache,
    ) {
    }

    #[Route('/', name: 'home')]
    public function __invoke()
    {
        dd($this->cache, $this->tagAwareCache);
//        $this->cache->
        $a = $this->tagAwareCache->get('asd', function (ItemInterface $item) {
            dd($item->set($item->getKey(),));
            return 'asd';
        });

        dd($a);

        return new JsonResponse('asd');
    }
}
