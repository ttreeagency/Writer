<?php

namespace Ttree\Writer;

use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\ContentRepository\Domain\Service\NodeTypeManager;
use Neos\Eel\ProtectedContextAwareInterface;
use Neos\Flow\Annotations as Flow;
use Neos\Utility\PositionalArraySorter;

class WriterLayoutHelper implements ProtectedContextAwareInterface
{
    /**
     * @var array
     * @Flow\InjectConfiguration(path="layout.blockRenderer")
     */
    protected $blockRenderer;

    public function hasLayout(NodeInterface $node, string $preset = 'default'): bool
    {
        return is_array($this->getConfiguration($node, $preset));
    }

    public function getLayout(NodeInterface $node, string $preset = 'default'): array
    {
        return (new PositionalArraySorter($this->getConfiguration($node, $preset) ?: []))->toArray();
    }

    public function getBlockType(NodeInterface $node, string $blockName, string $preset = 'default'): string
    {
        $blockConfiguration = $this->getConfiguration($node,$preset . '.' . $blockName);
        if ($blockConfiguration === null) {
            throw new \InvalidArgumentException('Invalid block name', 1524219151);
        }

        if (!isset($blockConfiguration['render']) || trim($blockConfiguration['render']) === '') {
            throw new \InvalidArgumentException('Missing render configuration for the current block', 1524219251);
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

    protected function getConfiguration(NodeInterface $node, string $path)
    {
        return $node->getNodeType()->getConfiguration('options.Ttree:Writer.layout.' . $path);
    }
}
