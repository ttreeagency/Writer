<?php

namespace Ttree\Writer;

use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\ContentRepository\Domain\Service\NodeTypeManager;
use Neos\Eel\ProtectedContextAwareInterface;
use Neos\Flow\Annotations as Flow;

class WriterLayoutHelper implements ProtectedContextAwareInterface
{
    /**
     * @var array
     * @Flow\InjectConfiguration(path="layout.blockRenderer")
     */
    protected $blockRenderer;

    public function hasLayout(NodeInterface $node, string $preset = 'default'): bool
    {
        return $node->getNodeType()->getConfiguration('options.Ttree:Writer.layout.' . $preset) !== null;
    }

    public function getLayout(NodeInterface $node, string $preset = 'default'): array
    {
        return $node->getNodeType()->getConfiguration('options.Ttree:Writer.layout.' . $preset);
    }

    public function getBlockType(NodeInterface $node, string $blockName, string $preset = 'default'): string
    {
        $blockConfiguration = $node->getNodeType()->getConfiguration('options.Ttree:Writer.layout.' . $preset . '.' . $blockName);
        if ($blockConfiguration === null) {
            throw \Neos\Flow\Exception('Invalid block name', 1524219151);
        }

        if (!isset($blockConfiguration['render']) || trim($blockConfiguration['render']) === '') {
            throw \Neos\Flow\Exception('Missing render configuration for the current block', 1524219251);
        }

        $render = trim($blockConfiguration['render']);

        list($type) = explode('.', $render);

        switch ($type) {
            case 'properties':
                return 'property';
            case 'childNodes':
                return 'childNode';
            default:
                return $render;
        }
    }

    public function allowsCallOfMethod($methodName)
    {
        return true;
    }
}