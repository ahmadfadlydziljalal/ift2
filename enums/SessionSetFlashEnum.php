<?php

namespace app\enums;

enum SessionSetFlashEnum: string
{
   case SUCCESS = 'success';
   case INFO = 'info';
   case DANGER = 'danger';
   case WARNING = 'warning';
}