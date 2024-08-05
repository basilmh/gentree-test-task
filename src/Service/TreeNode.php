<?php
/**
 * @author    Vasyl Minikh <mhbasil1@gmail.com>
 * @copyright 2024
 */
declare(strict_types=1);

namespace Gentree\Service;

/**
 * TreeNode class
 */
class TreeNode
{
    public const RELATED_TYPE_NAME = 'Прямые компоненты';
    private string $itemName;
    private ?string $parent;
    private array $children;
    private string $type;
    private ?string $relation;

    public function __construct(array $data)
    {
        $this->itemName = $data["Item Name"];
        $this->type = $data["Type"];
        $this->parent = $data["Parent"];
        $this->relation = $data["Relation"];
        $this->children = $data["children"] ?? [];
    }

    public function toArray(): array
    {
        return [

            'itemName' => $this->getItemName(),
            'parent' => $this->getParent(),
            'children' => $this->getChildren(),
        ];
    }
    public function getItemName(): string
    {
        return $this->itemName;
    }
    public function getParent(): ?string
    {
        return (empty($this->parent) ? null : $this->parent);
    }
    public function getChildren(): array
    {
        return $this->children;
    }
    public function addChildren($children): void
    {
        $this->children = array_merge($this->children, $children);
    }
    public function getType(): string
    {
        return $this->type;
    }
    public function getRelation(): ?string
    {
        return (empty($this->relation) ? null : $this->relation);
    }

    /**
     * if there is relation with parent data
     */
    public function isRelation(): bool
    {
        return ($this->type == self::RELATED_TYPE_NAME && $this->getRelation() !== null);
    }
}
