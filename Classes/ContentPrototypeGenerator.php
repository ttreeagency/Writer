<?php

namespace Ttree\Writer;

use Neos\ContentRepository\Domain\Model\NodeType;
use Neos\Flow\Annotations as Flow;
use Neos\Neos\Domain\Service\DefaultPrototypeGeneratorInterface;

/**
 * @Flow\Scope("singleton")
 * @api
 */
class ContentPrototypeGenerator implements DefaultPrototypeGeneratorInterface
{
    /**
     * @var string
     */
    protected $basePrototypeName = 'Neos.Neos:ContentComponent';

    public function generate(NodeType $nodeType)
    {
        if (strpos($nodeType->getName(), ':') === false) {
            return '';
        }

        $prototypeName = $nodeType->getName() . '.Writer';

        $output = [];
        $output[] = 'prototype(' . $prototypeName . ') < prototype(Carbon.Notification:Backend) {';
        $output[] = '    type = \'alert\'' . chr(10);
        $output[] = '    content = \'Configure the prototype <b>' . $prototypeName . '</b>\'';
        $output[] = '}';

        return implode(chr(10), $output) . chr(10) . chr(10);
    }
}
