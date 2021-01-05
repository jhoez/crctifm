select count(fkdepart)
from comedor.perscomedor
where fkdepart = 1
group by fkdepart
order by fkdepart;
