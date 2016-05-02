<?php

namespace Chefkoch\DisplayPatternLab\Document;

class Directory extends Base
{
    /**
     * @return int
     */
    public function getDepth()
    {
        $path = trim($this->getFile()->getRelativePathname(), '/');
        if ($path === '') {
            return 0;
        } else {
            return count(explode('/', $path));
        }
    }

    public function render()
    {
        $html = '<h' . ($this->getDepth() + 1) . '>' . $this->getFile()->getRelativePathname() . '</h' . ($this->getDepth() + 1) . '>';
        foreach ($this->getChildDocuments() as $childDocument) {
            $html .= $childDocument->render();
        }

        return $html;
    }
}
