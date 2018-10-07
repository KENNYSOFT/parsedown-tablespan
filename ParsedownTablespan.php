<?php
class ParsedownTablespan extends ParsedownExtra
{
    const VERSION = '1.0.0';

    protected function blockTableComplete(array $Block)
    {
        if ( ! isset($Block))
        {
            return null;
        }

        $HeaderElements =& $Block['element']['text'][0]['text'][0]['text'];

        for ($index = count($HeaderElements) - 1; $index >= 0; --$index)
        {
            $colspan = 1;
            $HeaderElement =& $HeaderElements[$index];

            while ($index && $HeaderElements[$index - 1]['text'] === '>')
            {
                $colspan++;
                $PreviousHeaderElement =& $HeaderElements[--$index];
                $PreviousHeaderElement['merged'] = true;
                if (isset($PreviousHeaderElement['attributes']))
                {
                    $HeaderElement['attributes'] = $PreviousHeaderElement['attributes'];
                }
            }

            if ($colspan > 1)
            {
                if ( ! isset($HeaderElement['attributes']))
                {
                    $HeaderElement['attributes'] = array();
                }
                $HeaderElement['attributes']['colspan'] = $colspan;
            }
        }

        for ($index = count($HeaderElements) - 1; $index >= 0; --$index)
        {
            if (isset($HeaderElements[$index]['merged']))
            {
                array_splice($HeaderElements, $index, 1);
            }
        }

        $Rows =& $Block['element']['text'][1]['text'];

        foreach ($Rows as $RowNo => &$Row)
        {
            $Elements =& $Row['text'];

            for ($index = count($Elements) - 1; $index >= 0; --$index)
            {
                $colspan = 1;
                $Element =& $Elements[$index];

                while ($index && $Elements[$index - 1]['text'] === '>')
                {
                    $colspan++;
                    $PreviousElement =& $Elements[--$index];
                    $PreviousElement['merged'] = true;
                    if (isset($PreviousElement['attributes']))
                    {
                        $Element['attributes'] = $PreviousElement['attributes'];
                    }
                }

                if ($colspan > 1)
                {
                    if ( ! isset($Element['attributes']))
                    {
                        $Element['attributes'] = array();
                    }
                    $Element['attributes']['colspan'] = $colspan;
                }
            }
        }

        foreach ($Rows as $RowNo => &$Row)
        {
            $Elements =& $Row['text'];

            foreach ($Elements as $index => &$Element)
            {
                $rowspan = 1;

                if (isset($Element['merged']))
                {
                    continue;
                }

                while ($RowNo + $rowspan < count($Rows) && $index < count($Rows[$RowNo + $rowspan]['text']) && $Rows[$RowNo + $rowspan]['text'][$index]['text'] === '^' && (@$Element['attributes']['colspan'] ?: null) === (@$Rows[$RowNo + $rowspan]['text'][$index]['attributes']['colspan'] ?: null))
                {
                    $Rows[$RowNo + $rowspan]['text'][$index]['merged'] = true;
                    $rowspan++;
                }

                if ($rowspan > 1)
                {
                    if ( ! isset($Element['attributes']))
                    {
                        $Element['attributes'] = array();
                    }
                    $Element['attributes']['rowspan'] = $rowspan;
                }
            }
        }

        foreach ($Rows as $RowNo => &$Row)
        {
            $Elements =& $Row['text'];

            for ($index = count($Elements) - 1; $index >= 0; --$index)
            {
                if (isset($Elements[$index]['merged']))
                {
                    array_splice($Elements, $index, 1);
                }
            }
        }

        return $Block;
    }
}