<?php

namespace Chefkoch\DisplayPatternLab\Model;

class ScssFile extends File
{

  public function getCssFileUrl()
  {
      return '/css/' . $this->getFile()->getRelativePath() . '/' . $this->getFilenameWithoutExtension() . '.css';
  }
}
