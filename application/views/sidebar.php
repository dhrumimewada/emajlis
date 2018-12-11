<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <!-- ========== Left Sidebar Start ========== -->

            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">
                    <!--- Divider -->
                    <div id="sidebar-menu">
                        <ul>

                            <li class="has_sub">
                                <a href="<?php echo base_url()."dashboard"; ?>" class="waves-effect"><i class="ti-home"></i> <span> Dashboard </span></a>
                            </li>

                            <li class="has_sub">
                                <a href="<?php echo base_url()."admins"; ?>" class="waves-effect<?php if($this->uri->segment(1) == 'admins' && ($this->uri->segment(2) == 'add' || $this->uri->segment(2) == 'edit')){?> active<?php }?>"><i class="ti-user"></i><span> Admins </span> </a>
                            </li>

                            <li class="has_sub">
                                <a href="<?php echo base_url()."members"; ?>" class="waves-effect<?php if($this->uri->segment(1) == 'members' && ($this->uri->segment(2) == 'add' || $this->uri->segment(2) == 'edit')){?> active<?php }?>"><i class="md-people-outline"></i><span> Members </span> </a>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect <?php if(($this->uri->segment(1) == 'vendor-partners' || $this->uri->segment(1) == 'vouchers') && ($this->uri->segment(2) == 'add' || $this->uri->segment(2) == 'edit')){?> active<?php }?>"><i class="md md-store"></i> <span> Vendors </span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled">
                                    <li class="<?php if($this->uri->segment(1) == 'vendor-partners' && ($this->uri->segment(2) == 'add' || $this->uri->segment(2) == 'edit')){?> active<?php }?>" ><a href="<?php echo base_url()."vendor-partners"; ?>">Partners</a></li>
                                    <li class="<?php if($this->uri->segment(1) == 'vouchers' && ($this->uri->segment(2) == 'add' || $this->uri->segment(2) == 'edit')){?> active<?php }?>"><a href="<?php echo base_url()."vouchers"; ?>">Vouchers</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="<?php echo base_url()."hashtags"; ?>" class="waves-effect<?php if($this->uri->segment(1) == 'hashtags' && ($this->uri->segment(2) == 'add' || $this->uri->segment(2) == 'edit')){?> active<?php }?>"><i class="fa fa-hashtag"></i><span> Hashtags </span> </a>
                            </li>
                            
                            <li class="has_sub">
                                <a href="<?php echo base_url()."advertisements"; ?>" class="waves-effect<?php if($this->uri->segment(1) == 'advertisements' && ($this->uri->segment(2) == 'add' || $this->uri->segment(2) == 'edit')){?> active<?php }?>"><i class="fa fa-bullhorn"></i><span> Advertisements </span> </a>
                            </li>

                            <li class="has_sub">
                                <a href="<?php echo base_url()."industry-looking-for"; ?>" class="waves-effect<?php if($this->uri->segment(1) == 'industry-looking-for' && ($this->uri->segment(2) == 'add' || $this->uri->segment(2) == 'edit')){?> active<?php }?>"><i class="fa fa-bullseye"></i><span> Goals </span> </a>
                            </li>

                            <li class="has_sub">
                                <a href="<?php echo base_url()."industry"; ?>" class="waves-effect<?php if($this->uri->segment(1) == 'industry' && ($this->uri->segment(2) == 'add' || $this->uri->segment(2) == 'edit')){?> active<?php }?>"><i class="fa fa-industry"></i><span> Industries </span> </a>
                            </li>

                            <li class="has_sub">
                                <a href="<?php echo base_url()."meeting-preference"; ?>" class="waves-effect<?php if($this->uri->segment(1) == 'meeting-preference' && ($this->uri->segment(2) == 'add' || $this->uri->segment(2) == 'edit')){?> active<?php }?>"><i class="fa fa-handshake-o"></i><span> Meeting Preferences </span> </a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- Left Sidebar End -->