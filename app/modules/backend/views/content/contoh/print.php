<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <style media="screen">
      table{
        border:1px solid black;
      }

      table thead th{
        padding :10px;
        text-align: center;
        border: 1px solid black;
      }

      table tbody tr td{
        padding :10px;
        text-align: center;
        border: 1px solid black;
      }

    </style>
  </head>

  <a href="#"  onclick="window.print()" >Cetak</a>
  <body>
    <?php $data = $this->db->get('config_bank'); ?>
    <table>
      <thead>
        <th>id_rekening</th>
        <th>id_bank</th>
        <th>nama_rekening</th>
        <th>No Rekening</th>
        <th>Aksi</th>
      </thead>
      <tbody>
        <?php foreach ($data->result() as $row): ?>
          <tr>
            <td><?=$row->id_rekening?></td>
            <td><?=$row->id_bank?></td>
            <td><?=$row->nama_rekening?></td>
            <td><?=$row->no_rekening?></td>
            <td>
              <a href="http://localhost/idea_project/backend/contoh/cetak/<?=$row->id_rekening?>"> Cetak</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>


  </body>
</html>
