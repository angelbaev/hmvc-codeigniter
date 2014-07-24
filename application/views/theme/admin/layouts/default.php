<h1>Default Layout</h1>

<table width="100%">
  <tr>
    <td><?php echo $this->load->controller('blog/preview', array('specials')); ?></td>
    <td><?php echo $content_for_layout; ?></td>
    <td>Column 3</td>
  </tr>
</table>