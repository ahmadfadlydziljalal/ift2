<?php

namespace app\enums;

enum TipePergerakanBarangEnum: int
{
   case START_PERTAMA_KALI_PENERAPAN_SISTEM = 0;
   case IN = 10;
   case MOVEMENT = 15;
   case MOVEMENT_FROM = 20;
   case MOVEMENT_TO = 30;
   case PEMBATALAN = 40;
   case OUT = 50;
}