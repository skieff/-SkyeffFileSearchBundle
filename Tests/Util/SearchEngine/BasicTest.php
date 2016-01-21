<?php

namespace Skyeff\FileSearchBundle\Tests\Util\SearchEngine;

use Skyeff\FileSearchBundle\Util\SearchEngine\Basic;

class BasicTest extends \PHPUnit_Framework_TestCase {

    /**
     * @param $lookupDirList
     * @param $maxAllowedFileSize
     * @param $searchString
     * @param $fileIterator
     * @param $expectedResult
     *
     * @dataProvider findFilesProvider
     */
    public function testFindFiles($lookupDirList, $maxAllowedFileSize, $searchString, $fileIterator, $expectedResult) {
        $basicStub = $this->getMockBuilder(Basic::class)
            ->setMethods(['createIterator'])
            ->setConstructorArgs([$lookupDirList, $maxAllowedFileSize])
            ->getMock();

        $basicStub->method('createIterator')->willReturn($fileIterator);

        $this->assertEquals($expectedResult, $basicStub->findFiles($searchString));
    }

    public function findFilesProvider() {
        return [
            //expects empty result as empty lookup dir list provided
            [[], 1000000, 'pattern', $this->createFileIterator() , []],

            //expects empty result as empty search term provided
            [['..'], 1000000, '', $this->createFileIterator() , []],

            //expects two files found
            [['..'], 1000000, 'pattern', $this->createFileIterator() , ['../match.1', '../match.2']],
        ];
    }

    private function createFileIterator() {
        return new \ArrayIterator([
            $this->fileStub('../not_a_file', false, true, 50, false, 'pattern'),
            $this->fileStub('../not_readable', true, false, 50, false, 'pattern'),
            $this->fileStub('../negative_size', true, true, -50, false, 'pattern'),
            $this->fileStub('../zero_size', true, true, 0, false, 'pattern'),
            $this->fileStub('../over_sized', true, true, 1500000, false, 'pattern'),
            $this->fileStub('../cannot_read_content', true, true, 18, true, 'pattern'),
            $this->fileStub('../no_matched_content', true, true, 18, false, 'no matched content'),
            $this->fileStub('../match.1', true, true, 35, false, 'other content pattern other content'),
            $this->fileStub('../match.2', true, true, 35, false, 'other content PATTERN other content'),
        ]);
    }

    private function fileStub($pathName, $isFile, $isReadable, $fileSize, $cannotRead, $content) {
        $fileObjectStub = $this->getMockBuilder(\SplFileObject::class)->setConstructorArgs(['/dev/null'])->getMock();
        $fileObjectStub->method('fread')->willReturn($cannotRead ? false : $content);

        $fileInfoStub = $this->getMockBuilder(\SplFileInfo::class)->disableOriginalConstructor()->getMock();
        $fileInfoStub->method('getPathname')->willReturn($pathName);
        $fileInfoStub->method('isFile')->willReturn($isFile);
        $fileInfoStub->method('isReadable')->willReturn($isReadable);
        $fileInfoStub->method('getSize')->willReturn($fileSize);
        $fileInfoStub->method('openFile')->willReturn($fileObjectStub);

        return $fileInfoStub;
    }
}