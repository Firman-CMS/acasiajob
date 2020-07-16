<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>

<h2>Page 2 | List Data</h2>
<a href="/fabelio/">Page 1</a> |
 <a href="/fabelio/">Page 3</a> 
<table>
  <tr>
    <th>Name</th>
    <th>Url</th>
    <th>Price</th>
    <th>Sale Price</th>
    <th>Product image</th>
  </tr>
  <?php foreach ($data as $value) { ?>
    <tr>
        <td><?php echo $value->name ?></td>
        <td><?php echo $value->url ?></td>
        <td><?php echo $value->unit_price ?></td>
        <td><?php echo $value->unit_sale_price ?></td>
        <td> <img src="<?php echo $value->product_image_url ?>" width="100" height="100"> </td>
    </tr>
  <?php } ?>
</table>

</body>
</html>
