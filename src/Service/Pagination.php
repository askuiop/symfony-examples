<?php
/**
 * Created by PhpStorm.
 * User: jims
 * Date: 18-4-3
 * Time: 下午5:38
 */

namespace App\Service;



use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Pagination
{
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function generate($routeName, $currentPage, $totalPage, array $paramsAry, $length=9)
    {
        $page = $currentPage;
        unset($paramsAry['page']);
        $pageBaseUrl = $this->urlGenerator->generate($routeName, $paramsAry);
        $pageBaseUrl .= '&page=';

        $offset = floor($length/2);
        $pagination = [
            'current_page' => $page,
            'total_page' => $totalPage,
            'previous_page' => $pageBaseUrl. ( ($page<=1)? $page : $page-1 ) ,
            'next_page' => $pageBaseUrl. ( ($page>=$totalPage)? $page : $page+1 ) ,
            'start' => ($page>$offset)?($page-$offset): 1 ,
            'end' => ( ($page+$offset) >$totalPage)?$totalPage:($page+$offset) ,
            'base_url' => $pageBaseUrl,
        ];

        return $pagination;
    }


}