<?php

namespace KingOfCode\Upload;

use Illuminate\Support\Facades\Storage;

class Replicator
{
    /**
     * @param string $pathTemplate
     * @param array $types
     * @return string
     */
    public function replicateImages($pathTemplate, $types)
    {
        foreach ($types as $type) {
            $resolvedFilePath = str_replace('{type}', $type, $pathTemplate);

            $destPath = $this->replicateFile($resolvedFilePath);
        }

        return $this->getDestFilePath($pathTemplate, $destPath);
    }

    /**
     * @param string $srcPath
     * @return string
     */
    public function replicateFile($srcPath)
    {
        $srcFileName = basename($srcPath);
        $copyCount = 1;

        do {
            $destFileName = $copyCount++ . '_' . $srcFileName;
            $destPath = $this->getDestFilePath($srcPath, $destFileName);
        } while (Storage::exists($destPath));

        Storage::copy($srcPath, $destPath);

        return $destPath;
    }

    /**
     * @param string $srcPath
     * @param string $destPath
     * @return string
     */
    private function getDestFilePath($srcPath, $destPath)
    {
        return dirname($srcPath) . '/' . basename($destPath);
    }
}
