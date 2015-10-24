<style>
    .title{
        width: 100px;
    }
</style>
<div style="text-align: center !important; margin-top: 100px; margin-left: 37%">
    <form id="formLogin" method="POST" action="<?php echo site_url('login/login/prosesLogin'); ?>">
        <div class="span6 row-fluid" style="margin-left:-15px; margin-top:-16px;  width:350px; height:180px; border: 1px solid; border-radius: 4px 4px 4px 4px; background-color: #fff;">
            <div class="span12 btn-inverse"><p style="margin: 9px auto auto 10px;">Login</p></div>
            <div class="span12 row-fluid" style="padding-left:18px; padding-top:26px; margin-left:6px">
                <table>
                    <tr>
                        <td class="title">Username</td>
                        <td><input type="text" name="username" id="username" class="input-medium" required/></td>
                    </tr>
                    <tr>
                        <td class="title">Password</td>
                        <td><input type="password" name="password" id="password" class="input-medium" required/></td>
                    </tr>
                </table>
            </div>
            <div class="span12 row-fluid" style="margin-top: 5px;">
                <button type="submit" id="btnProsesLogin" class="btn btn-login btn-primary">LOGIN</button>
                <button type="button" id="btnBatalLogin" class="btn btn" >BATAL</button>
            </div>
            <div>
                <span id="messageVerifikasi" style="display: none;">
                    <?php
                    $pesan = $this->session->flashdata('message');
                    echo $pesan == '' ? '' : '<p id="error">' . $pesan . '</p>';
                    ?>
                </span>
            </div>
        </div>
    </form>
</div>