<?php

class FinderPolindrom
{
    /**
     * @var string
     */
    private $text;
    /**
     * @var string
     */
    private $polindrom;

    public function search()
    {
        for ($m = 1; $m <= mb_strlen($this->text); $m++) {
            for ($n = 0; $n < $m; $n++) {
                $length = $m - $n;
                if ($length <= mb_strlen($this->polindrom)) {
                    continue;
                }
                $subText = mb_substr($this->text, $n, $length);
                if (
                $this->isPolindrom($subText)
                ) {
                    $this->polindrom = $subText;
                }
            }
        }
    }

    public function isPolindrom($text): bool
    {
        return $this->reverseText($text) === $text;
    }

    /**
     * @param $text
     *
     * @return string
     */
    private function reverseText($text): string
    {
        return implode('', array_reverse(preg_split('//u', $text)));
    }

    /**
     * @return string
     */
    public function getPolindrom(): string
    {
        return $this->polindrom;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text)
    {
        $this->text = mb_strtolower(preg_replace('/\s+/', '', $text));
    }
}