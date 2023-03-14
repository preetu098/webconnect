"use strict"
function fullCalender(){var calendarEl=document.getElementById('calendar');var calendar=new FullCalendar.Calendar(calendarEl,{headerToolbar:{left:'title,prev,next',right:'today',center:'dayGridMonth,timeGridWeek,timeGridDay'},selectable:true,selectMirror:true,select:function(arg){var title=prompt('Event Title:');if(title){calendar.addEvent({title:title,start:arg.start,end:arg.end,allDay:arg.allDay})}
calendar.unselect()},editable:true,droppable:true,drop:function(arg){if(document.getElementById('drop-remove').checked){arg.draggedEl.parentNode.removeChild(arg.draggedEl);}},initialDate:'2021-02-13',weekNumbers:true,navLinks:true,editable:true,selectable:true,nowIndicator:true,views:{settimana:{type:'agendaWeek',duration:{days:7},title:'Apertura',columnFormat:'dddd',hiddenDays:[0,6]}},defaultView:'settimana',events:[{title:'All Day Event',start:'2021-02-01'},{title:'Annual Meeting Envatos Community with Kleon Team',start:'2021-02-07',end:'2021-02-10',className:"bg-danger"},{groupId:999,title:'Repeating Event',start:'2021-02-09T16:00:00'},{groupId:999,title:'Repeating Event',start:'2021-02-16T16:00:00'},{title:'Conference',start:'2021-02-11',end:'2021-02-13',className:"bg-danger"},{title:'Lunch',start:'2021-02-12T12:00:00'},{title:'Meeting',start:'2021-04-12T14:30:00'},{title:'Happy Hour',start:'2021-07-12T17:30:00'},{title:'Dinner',start:'2021-02-12T20:00:00',className:"bg-warning"},{title:'Birthday Party',start:'2021-02-13T07:00:00',className:"bg-secondary"},{title:'Click for Google',url:'http://google.com/',start:'2021-02-28'}]});calendar.render();}
jQuery(window).on('load',function(){setTimeout(function(){fullCalender();},1000);});