select
p.name,
sum(l.nds),
sum(c.nds)
from procedure as p
left join lot as l on l.procedure_id=p.id
left join client as c on c.lot_id=l.id
group by p.name;
