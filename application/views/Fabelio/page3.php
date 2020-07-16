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

<h2>Page 3 | Result</h2>
<a href="/fabelio/">Page 1</a> |
 <a href="/fabelio/list">Page 2</a> 
<?php if($data) {?>
<table>
  <tr>
    <th>Name</th>
    <th>Url</th>
    <th>Price</th>
    <th>Sale Price</th>
    <th>Product image</th>
  </tr>
  <tr>
      <td><?php echo $data->name ?></td>
      <td><?php echo $data->url ?></td>
      <td><?php echo $data->unit_price ?></td>
      <td><?php echo $data->unit_sale_price ?></td>
      <td> <img src="<?php echo $data->product_image_url ?>" width="100" height="100"> </td>
  </tr>
</table>
<?php } else { ?>
  <h2>No Result</h2>
<?php } ?>
</body>
</html>
