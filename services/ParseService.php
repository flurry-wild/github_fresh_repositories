<?php

namespace app\services;

use Exception;
use simple_html_dom\simple_html_dom_node;
use simple_html_dom\simple_html_dom;

class ParseService
{
    /**
     * @param simple_html_dom | simple_html_dom_node $dom
     * @param array $containers
     *
     * @return simple_html_dom_node
     *
     * @throws Exception
     */
    public function parseContainer($dom, array $containers): simple_html_dom_node
    {
        $input = $dom;
        foreach ($containers as $container) {
            if (!isset($container['tag'])) {
                $tag = $container;
                $container = [
                    'tag' => $tag,
                    'key' => 0,
                ];
            }

            $input = $input->find($container['tag'])[$container['key']];
            if (empty($input)) throw new Exception();
        }

        return $input;
    }
}
