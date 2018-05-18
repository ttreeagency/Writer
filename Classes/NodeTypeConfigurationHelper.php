<?php

namespace Ttree\Writer;

use Neos\ContentRepository\Domain\Model\NodeType;
use Neos\ContentRepository\Domain\Service\NodeTypeManager;
use Neos\Eel\ProtectedContextAwareInterface;
use Neos\Flow\Annotations as Flow;

class NodeTypeConfigurationHelper implements ProtectedContextAwareInterface
{
    const EDITOR_ENVELOPE = 'Flowpack.StructuredEditing/EditorEnvelope';

    /**
     * @var NodeTypeManager
     * @Flow\Inject
     */
    protected $nodeTypeManager;

    public function get(NodeType $nodeType, string $path)
    {
        return $nodeType->getConfiguration($path);
    }

    public function hasStructuredEditing(NodeType $nodeType, string $propertyName): bool
    {
        return $nodeType->getConfiguration('properties.' . $propertyName . '.ui.inline.editor') === self::EDITOR_ENVELOPE;
    }

    public function allowsCallOfMethod($methodName)
    {
        return true;
    }
}
