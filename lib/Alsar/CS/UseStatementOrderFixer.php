<?php
namespace Alsar\CS;

use Symfony\CS\FixerInterface;

class UseStatementOrderFixer implements FixerInterface
{
    public function fix(\SplFileInfo $file, $content)
    {
        preg_match_all('/^use .*;/m', $content, $matches);

        $useStatements = $matches[0];

        if (count($useStatements) > 0) {
            $startPosition = strpos($content, $useStatements[0]);

            $orderedUseStatements = $useStatements;
            sort($orderedUseStatements);

            foreach ($useStatements as $statement) {
                $content = str_replace($statement, '', $content);
            }

            $content = substr_replace($content, implode(PHP_EOL, $orderedUseStatements), $startPosition, 0);
        }

        return $content;
    }

    public function getLevel()
    {
        return FixerInterface::ALL_LEVEL;
    }

    public function getPriority()
    {
        return 100;
    }

    public function supports(\SplFileInfo $file)
    {
        return 'php' == pathinfo($file->getFilename(), PATHINFO_EXTENSION);
    }

    public function getName()
    {
        return 'order_use';
    }

    public function getDescription()
    {
        return 'Order use statements in alphabetical order.';
    }
}