<style type="text/css">
/* Pagination */
.pgcu_pagination {
  text-align: center;
  margin-bottom: 0;
}

.pgcu_pagination .page-numbers {
  color:<?php if(empty($pagi_text_color)) {echo "#000000";}else { echo $pagi_text_color;}?>;
}
.pgcu_pagination .page-numbers:hover {
  color:<?php if(empty($pagi_text_hover_color)) {echo "#FF0000";}else { echo $pagi_text_hover_color;}?>;
}
.pgcu_pagination ul {
  display: -webkit-inline-box;
  display: -webkit-inline-flex;
  display: -ms-inline-flexbox;
  display: inline-flex;
  -webkit-flex-wrap: wrap;
      -ms-flex-wrap: wrap;
          flex-wrap: wrap;
  border: 1px solid #e4e4ed;
  -webkit-border-radius: 2px;
          border-radius: 2px;
  align-items:center;
}

.pgcu_pagination ul a.page-numbers, .pgcu_pagination ul span.page-numbers {
  border-left: 1px solid #e4e4ed;
  margin-bottom: 0;
}
.pgcu_pagination ul a.page-numbers:first-child{
  border-left: 0 none;
}

.pgcu_pagination ul a, .pgcu_pagination ul span {
  line-height: 40px;
  padding: 0 15px;
  display: block;
  font-size: 16px;
}
.pgcu_pagination ul span.current{
  border:0 none;
  background: <?php if(empty($pagi_active_back_color)) {echo "#dda146";}else { echo $pagi_active_back_color;}?>;
  border-radius: 0;
  color: <?php if(empty($pagi_text_active_color)) {echo "#ffffff";}else { echo $pagi_text_active_color;}?>;
}
.pgcu_pagination ul span.dots{
  border:0 none;
  border-left: 1px solid #e4e4ed;
  background: none;
  border-radius: 0;
  box-shadow: none;
}

.pgcu_pagination ul li:nth-child(5) {
  padding: 0 15px;
  line-height: 32px;
}

.pgcu_pagination ul li.active a {
  background: #f42156;
  color: #fff;
}
</style>