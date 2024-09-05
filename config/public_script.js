function formatrp(val,row){
    return number_format(val,0,',','.');
  }
  function number_format(num,dig,dec,sep) {
      x=new Array();
      s=(num<0?"-":"");
      num=Math.abs(num).toFixed(dig).split(".");
      r=num[0].split("").reverse();
      for(var i=1;i<=r.length;i++){x.unshift(r[i-1]);if(i%3==0&&i!=r.length)x.unshift(sep);}
      return s+x.join("")+(num[1]?dec+num[1]:"");
  }

  function addCommas(nStr) {
      nStr += '';
      var x = nStr.split('.');
      var x1 = x[0];
      var x2 = x.length > 1 ? '.' + x[1] : '';
      var rgx = /(\d+)(\d{3})/;
      while (rgx.test(x1)) {
      x1 = x1.replace(rgx, '$1' + ',' + '$2');
      }
      return x1 + x2;
  }