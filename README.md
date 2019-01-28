# Parsedown Tablespan

An extension of [ParsedownExtra](https://github.com/erusev/parsedown-extra) and [Parsedown](http://parsedown.org/) that adds support for rowspan and colspan.

## Installation

### Composer

Install the [composer package](https://packagist.org/packages/kennysoft/parsedown-tablespan "The Parsedown Tablespan package on packagist.org") by running the following command:

```bash
composer require kennysoft/parsedown-tablespan
```

### Manual

1. Download the "Source code" from the [latest release](https://github.com/KENNYSOFT/parsedown-tablespan/releases/latest "The latest release of Parsedown Tablespan")
2. Include `Parsedown.php`, `ParsedownExtra.php`, and `ParsedownTablespan.php`

## Example

```php
$ParsedownTablespan = new ParsedownTablespan();

echo $ParsedownTablespan->text('
| >     | >           |   Colspan    | >           | for thead |
| ----- | :---------: | -----------: | ----------- | --------- |
| Lorem | ipsum       |    dolor     | sit         | amet      |
| ^     | -           |      >       | right align | .         |
| ,     | >           | center align | >           | 2x2 cell  |
| >     | another 2x2 |      +       | >           | ^         |
| >     | ^           |              |             | !         |
');
```

Prints:

<table>
<thead>
<tr>
<th align="center" style="text-align: center;" colspan="3">Colspan</th>
<th colspan="2">for thead</th>
</tr>
</thead>
<tbody>
<tr>
<td rowspan="2">Lorem</td>
<td align="center" style="text-align: center;">ipsum</td>
<td align="right" style="text-align: right;">dolor</td>
<td>sit</td>
<td>amet</td>
</tr>
<tr>
<td align="center" style="text-align: center;">-</td>
<td align="right" style="text-align: right;" colspan="2">right align</td>
<td>.</td>
</tr>
<tr>
<td>,</td>
<td align="center" style="text-align: center;" colspan="2">center align</td>
<td colspan="2" rowspan="2">2x2 cell</td>
</tr>
<tr>
<td align="center" style="text-align: center;" colspan="2" rowspan="2">another 2x2</td>
<td align="right" style="text-align: right;">+</td>
</tr>
<tr>
<td align="right" style="text-align: right;"></td>
<td></td>
<td>!</td>
</tr>
</tbody>
</table>

_(Since GitHub does not accept style attribute for cells, upper table is made with `align` attribute which is not supported in HTML5, just to show what will be generated.)_

## License

- [MIT](http://opensource.org/licenses/MIT)

## Author

KENNYSOFT <hyeonmin.park@kennysoft.kr>