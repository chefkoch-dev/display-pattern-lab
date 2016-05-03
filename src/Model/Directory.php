<?php

namespace Chefkoch\DisplayPatternLab\Model;

class Directory extends Document
{

    /** @var Document */
    private $documentation;

    /**
     * @param Document[] $documents
     */
    public function fill(array $documents)
    {
        $patterns = array();
        foreach ($documents as $document) {
            if ($document->getFile()->isDir()) {
                $this->addChild($document);
            } elseif ($document->getFile()->getFilename() == $this->getFile()->getFilename() . '.md') {
                $this->documentation = $document;
            } else {
                $fileNameWithoutExtension = $document->getFilenameWithoutExtension();
                $fileNameParts = explode('--', $fileNameWithoutExtension);
                $patternName = $fileNameParts[0];
                $patterns[$patternName][] = $document;
            }
        }

        foreach ($patterns as $patternName => $patternDocuments) {
            $pattern = new Pattern($patternName);
            $this->addChild($pattern, $patternName);
            $pattern->fill($patternDocuments);
        }
    }

    /**
     * @return Document
     */
    public function getDocumentation()
    {
        return $this->documentation;
    }
}
