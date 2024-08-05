<?php
/**
 * @author    Vasyl Minikh <mhbasil1@gmail.com>
 * @copyright 2024
 */
declare(strict_types=1);

namespace Gentree\Service;

use Exception;
use Iterator;

/**
 * TreeBuilder class
 */
class TreeBuilder
{
    public const NODE_NOTE_EXIST_MESSAGE = 'Data for node %s not found';
    private array $mappedTreeData = [];
    private array $childrenNodes = [];

    /**
     * Build tree structure
     * @throws Exception
     */
    public function build(Iterator $lines): array
    {
        $this->mappedTreeData = [];
        foreach ($lines as $line) {
            $this->mappedTreeData[$line['Item Name']] = $line;
        }
        $result = [];
        foreach ($this->getMainNodeIds() as $mainNodeId) {
            $result[] = $this->buildNodeData($mainNodeId)->toArray();
        }
        return $result;
    }

    /**
     * get or create new Node by Id
     * @throws Exception
     */
    private function getOrCreateChildrenNode(string $nodeId): TreeNode|array
    {
        if (!array_key_exists($nodeId, $this->childrenNodes)) {
            $this->childrenNodes[$nodeId] = $this->buildNodeData($nodeId);
        }
        return $this->childrenNodes[$nodeId];
    }

    /**
     * get ids for Main Nodes (without parent)
     */
    private function getMainNodeIds(): array
    {
        $mainNodeIds = [];
        foreach ($this->mappedTreeData as $data) {
            if ($data['Parent'] == null) {
                $mainNodeIds = array_merge($mainNodeIds, [$data['Item Name']]);
            }
        }
        return $mainNodeIds;
    }

    /**
     * get Final structure of node
     * @throws Exception
     */
    private function buildNodeData(string $nodeId): TreeNode
    {
        if (!array_key_exists($nodeId, $this->mappedTreeData)) {
            throw new Exception(sprintf(self::NODE_NOTE_EXIST_MESSAGE, $nodeId));
        }

        $node = new TreeNode($this->mappedTreeData[$nodeId]);
        $node->addChildren($this->buildTreeData($nodeId));

        return $node;
    }

    /**
     * get children data for node
     * @throws Exception
     */
    private function buildTreeData(mixed $parentId = null): array
    {
        $tree = [];

        foreach ($this->mappedTreeData as $key => $element) {
            $node = new TreeNode($element);
            if ($node->getParent() == $parentId) {
                $children = $this->buildTreeData($key);

                if ($children) {
                    $node->addChildren($children);
                }

                if ($node->isRelation()) {
                    $childrenNode = $this->getOrCreateChildrenNode($node->getRelation());
                    $node->addChildren($childrenNode->getChildren());
                }

                $tree[] = $node->toArray();
            }
        }

        return $tree;
    }
}
