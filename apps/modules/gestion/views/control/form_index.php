<script type="text/javascript">
	var tab = Ext.getCmp(inicio.id+'-tabContent');
	if(!Ext.getCmp('control-tab')){
		var control = {
			id:'control',
			id_menu:'<?php echo $p["id_menu"];?>',
			url:'/gestion/control/',
			opcion:'I',
			id_pag:0,
			shi_codigo:0,
			id_det:0,
			id_lote:0,
			trabajando:1,
			recordsToSend:[],
			init:function(){
				Ext.tip.QuickTipManager.init();

				Ext.define('Task', {
				    extend: 'Ext.data.TreeModel',
				    fields: [
				        {name: 'id_lote', type: 'string'},
				        {name: 'shi_codigo', type: 'string'},
				        {name: 'fac_cliente', type: 'string'},
				        {name: 'lot_estado', type: 'string'},
	                    {name: 'tipdoc', type: 'string'},
	                    {name: 'nombre', type: 'string'},
	                    {name: 'lote_nombre', type: 'string'},
	                    {name: 'descripcion', type: 'string'},
	                    {name: 'fecha', type: 'string'},
	                    {name: 'tot_folder', type: 'string'},
	                    {name: 'tot_pag', type: 'string'},
	                    {name: 'tot_errpag', type: 'string'},
	                    {name: 'id_user', type: 'string'},
	                    {name: 'usr_update', type: 'string'},
	                    {name: 'fec_update', type: 'string'},
	                    {name: 'estado', type: 'string'}
				    ]
				});
				var storeTree = new Ext.data.TreeStore({
	                model: 'Task',
				    autoLoad:false,
	                proxy: {
	                    type: 'ajax',
	                    url: control.url+'get_list_lotizer/'//,
	                    //reader:{
	                    //    type: 'json'//,
	                    //    //rootProperty: 'data'
	                    //}
	                },
	                folderSort: true,
	                listeners:{
	                	beforeload: function (store, operation, opts) {
					        /*Ext.apply(operation, {
					            params: {
					                to: 'test1',
		    						from: 'test2'
					            }
					       });*/
					    },
	                    load: function(obj, records, successful, opts){
	                 		Ext.getCmp(control.id + '-grid').doLayout();
	                 		//Ext.getCmp(control.id + '-grid').getView().getRow(0).style.display = 'none';
	                 		storeTree.removeAt(0);
	                 		Ext.getCmp(control.id + '-grid').collapseAll();
		                    Ext.getCmp(control.id + '-grid').getRootNode().cascadeBy(function (node) {
		                          if (node.getDepth() < 1) { node.expand(); }
		                          if (node.getDepth() == 0) { return false; }
		                     });
		                    Ext.getCmp(control.id + '-grid').expandAll();
	                    }
	                }
	            });
				this.msgTpl = new Ext.Template(
		            'Sounds Effects: <b>{fx}%</b><br />',
		            'Ambient Sounds: <b>{ambient}%</b><br />',
		            'Interface Sounds: <b>{iface}%</b>'
		        );
				var store = Ext.create('Ext.data.Store',{
                fields: [
                    {name: 'cod_lote', type: 'string'},
                    {name: 'lote', type: 'string'},
                    {name: 'fecha', type: 'string'},
                    {name: 'usuario', type: 'string'},
                    {name: 'cantidad', type: 'string'}
                ],
                autoLoad:false,
                proxy:{
                    type: 'ajax',
                    url: control.url+'get_list/?vp_cod_lote=0',
                    reader:{
                        type: 'json',
                        rootProperty: 'data'
                    }
                },
                listeners:{
                    load: function(obj, records, successful, opts){
                        
                    }
                }
            });

			var store_paginas = Ext.create('Ext.data.Store',{
                fields: [
                    {name: 'id_pag', type: 'string'},
                    {name: 'id_det', type: 'string'},
                    {name: 'id_lote', type: 'string'},
                    {name: 'path', type: 'string'},
                    {name: 'file', type: 'string'},
                    {name: 'lado', type: 'string'},
                    {name: 'ocr', type: 'string'},
                    {name: 'estado', type: 'string'},
                    {name: 'include', type: 'string'}
                ],
                autoLoad:false,
                proxy:{
                    type: 'ajax',
                    url: control.url+'get_load_page/',
                    reader:{
                        type: 'json',
                        rootProperty: 'data'
                    }
                },
                listeners:{
                    load: function(obj, records, successful, opts){
                        
                    }
                }
            });

			var store_shipper = Ext.create('Ext.data.Store',{
                fields: [
                    {name: 'shi_codigo', type: 'string'},
                    {name: 'shi_nombre', type: 'string'},
                    {name: 'shi_logo', type: 'string'},
                    {name: 'fec_ingreso', type: 'string'},                    
                    {name: 'shi_estado', type: 'string'},
                    {name: 'id_user', type: 'string'},
                    {name: 'fecha_actual', type: 'string'}
                ],
                autoLoad:true,
                proxy:{
                    type: 'ajax',
                    url: control.url+'get_list_shipper/',
                    reader:{
                        type: 'json',
                        rootProperty: 'data'
                    }
                },
                listeners:{
                    load: function(obj, records, successful, opts){
                        
                    }
                }
            });
            var store_contratos = Ext.create('Ext.data.Store',{
                fields: [
                    {name: 'fac_cliente', type: 'string'},
                    {name: 'cod_contrato', type: 'string'},
                    {name: 'pro_descri', type: 'string'}
                ],
                autoLoad:false,
                proxy:{
                    type: 'ajax',
                    url: control.url+'get_list_contratos/',
                    reader:{
                        type: 'json',
                        rootProperty: 'data'
                    }
                },
                listeners:{
                    load: function(obj, records, successful, opts){
                        
                    }
                }
            });

		    var myDataLote = [
				['A','Activo'],
			    ['I','Inactivo']
			];
			var store_estado_lote = Ext.create('Ext.data.ArrayStore', {
		        storeId: 'estado',
		        autoLoad: true,
		        data: myDataLote,
		        fields: ['code', 'name']
		    });
			
			var myData = [
			    [1,'Activo'],
			    [0,'Inactivo']
			];
			var store_estado = Ext.create('Ext.data.ArrayStore', {
		        storeId: 'estado',
		        autoLoad: true,
		        data: myData,
		        fields: ['code', 'name']
		    });

				var panel = Ext.create('Ext.form.Panel',{
					id:control.id+'-form',
					bodyStyle: 'background: transparent',
					border:false,
					region:'center',
					layout:'border',
					defaults:{
						border:false
					},
					tbar:[],
					items:[
						{
							region:'west',
							id:control.id+'-panel-west',
							border:true,
							width:350,
							layout:'border',
							border:true,
							padding:'5px 5px 5px 5px',
							items:[
								{
		                            region:'north',
		                            border:false,
		                            xtype: 'uePanelS',
		                            logo: 'BE',
		                            title: 'Control de Lotes',
		                            legend: 'Seleccione el Lote Registrado',
		                            width:350,
		                            height:210,
		                            items:[
		                                {
		                                    xtype:'panel',
		                                    border:false,
		                                    bodyStyle: 'background: transparent',
		                                    padding:'2px 5px 1px 5px',
		                                    layout:'column',
		                                    items: [
		                                    	{
			                                   		width: 300,border:false,
			                                    	padding:'0px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
			                                 		items:[
			                                              {
				                                            xtype:'combo',
				                                            fieldLabel: 'Cliente',
				                                            id:control.id+'-cbx-cliente',
				                                            store: store_shipper,
				                                            queryMode: 'local',
				                                            triggerAction: 'all',
				                                            valueField: 'shi_codigo',
				                                            displayField: 'shi_nombre',
				                                            emptyText: '[Seleccione]',
				                                            labelAlign:'right',
				                                            //allowBlank: false,
				                                            labelWidth: 50,
				                                            width:'100%',
				                                            anchor:'100%',
				                                            //readOnly: true,
				                                            listeners:{
				                                                afterrender:function(obj, e){
				                                                    // obj.getStore().load();
				                                                },
				                                                select:function(obj, records, eOpts){
				                                                	Ext.getCmp(control.id+'-cbx-contrato').setValue('');
				                                        			control.getContratos(records.get('shi_codigo'));
				                                                }
				                                            }
				                                        }
			                                 		]
			                                    },
			                                    {
			                                   		width: 300,border:false,
			                                    	padding:'10px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
			                                 		items:[
			                                                {
			                                                    xtype:'combo',
			                                                    fieldLabel: 'Contrato',
			                                                    id:control.id+'-cbx-contrato',
			                                                    store: store_contratos,
			                                                    queryMode: 'local',
			                                                    triggerAction: 'all',
			                                                    valueField: 'fac_cliente',
			                                                    displayField: 'pro_descri',
			                                                    emptyText: '[Seleccione]',
			                                                    labelAlign:'right',
			                                                    //allowBlank: false,
			                                                    labelWidth: 50,
			                                                    width:'100%',
			                                                    anchor:'100%',
			                                                    //readOnly: true,
			                                                    listeners:{
			                                                        afterrender:function(obj, e){
			                                                            // obj.getStore().load();
			                                                        },
			                                                        select:function(obj, records, eOpts){ 
			                                                			
			                                                        }
			                                                    }
			                                                }
			                                 		]
			                                    },
			                                    {
		                                            width:300,border:false,
		                                            padding:'0px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
		                                            items:[
		                                                {
		                                                    xtype: 'textfield',	
		                                                    fieldLabel: 'N° Lote',
		                                                    id:control.id+'-txt-lote',
		                                                    labelWidth:50,
		                                                    maskRe: /[0-9]/,
		                                                    //readOnly:true,
		                                                    labelAlign:'right',
		                                                    width:'100%',
		                                                    anchor:'100%'
		                                                }
		                                            ]
		                                        },
		                                        {
		                                            width:300,border:false,
		                                            padding:'0px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
		                                            items:[
		                                                {
		                                                    xtype: 'textfield',	
		                                                    fieldLabel: 'Nombre',
		                                                    id:control.id+'-txt-control',
		                                                    labelWidth: 50,
		                                                    //readOnly:true,
		                                                    labelAlign:'right',
		                                                    width:'100%',
		                                                    anchor:'100%'
		                                                }
		                                            ]
		                                        },
		                                        {
			                                        width: 300,border:false,
			                                        padding:'0px 2px 5px 0px',  
			                                    	bodyStyle: 'background: transparent',
			                                    	layout:'column',
			                                        items:[
			                                            {
			                                                xtype:'datefield',
			                                                id:control.id+'-txt-fecha-filtro',
			                                                padding:'0px 10px 0px 0px',  
			                                                fieldLabel:'Fecha',
			                                                labelWidth: 50,
			                                                labelAlign:'right',
			                                                value:new Date(),
			                                                format: 'Ymd',
			                                                //readOnly:true,
			                                                width: 187,
			                                                anchor:'100%'
			                                            },
			                                            {
									                        xtype:'button',
									                        width:100,
									                        text: 'Buscar',
									                        icon: '/images/icon/binocular.png',
									                        listeners:{
									                            beforerender: function(obj, opts){
									                                /*global.permisos({
									                                    id: 15,
									                                    id_btn: obj.getId(), 
									                                    id_menu: gestion_devolucion.id_menu,
									                                    fn: ['panel_asignar_gestion.limpiar']
									                                });*/
									                            },
									                            click: function(obj, e){	             	
		                               					            control.getReloadGridcontrol();
									                            }
									                        }
									                    }
			                                        ]
			                                    }
		                                    ]
		                                }
		                            ]
		                        },
								{
									region:'center',
									layout:'fit',
									border:true,
									padding:'5px 5px 5px 5px',
									items:[
										{
					                        xtype: 'treepanel',
					                        //collapsible: true,
									        useArrows: true,
									        rootVisible: true,
									        multiSelect: true,
									        //root:'Task',
					                        id: control.id + '-grid',
					                        //height: 370,
					                        //reserveScrollbar: true,
					                        //rootVisible: false,
					                        //store: store,
					                        //layout:'fit',
					                        columnLines: true,
					                        store: storeTree,
								            columns: [
									            {
									            	xtype: 'treecolumn',
				                                    text: 'Nombre',
				                                    dataIndex: 'lote_nombre',
				                                    renderer: control.renderTip,
				                                    sortable: true,
				                                    flex: 1
				                                },
				                                /*{
				                                    text: 'Estado Lote',
				                                    dataIndex: 'lot_estado',
				                                    loocked : true,
				                                    width: 100,
				                                    align: 'center',
				                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
				                                        //console.log(record);
				                                        metaData.style = "padding: 0px; margin: 0px";
				                                        if(parseInt(record.get('nivel'))==1){
					                                        var estado = (record.get('lot_estado')=='LT')?'baggage_cart_box.png':'contraer.png';
					                                        var qtip = (record.get('lot_estado')=='LT')?'Lotizado.':'Lote en otro Estado.';
				                                        }else{
				                                        	var estado = (record.get('lot_estado')=='LT')?'basket_put_gray.png':'basket_put.png';
					                                        var qtip = (record.get('lot_estado')=='LT')?'Folder Vacio.':'Folder en otro Estado.';
				                                        }
				                                        

				                                        return global.permisos({
				                                            type: 'link',
				                                            id_menu: control.id_menu,
				                                            icons:[
				                                                {id_serv: 1, img: estado, qtip: qtip, js: ""}
				                                            ]
				                                        });
				                                    }
				                                },*/
				                                {
				                                    text: 'Folders',
				                                    dataIndex: 'tot_folder',
				                                    width: 45,
				                                    align: 'center'
				                                },
				                                {
				                                    text: 'Páginas',
				                                    dataIndex: 'tot_pag',
				                                    width: 50,
				                                    align: 'center'
				                                },
				                                {
				                                    text: 'Cerrar',
				                                    dataIndex: 'estado',
				                                    //loocked : true,
				                                    width: 50,
				                                    align: 'center',
				                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
				                                        //console.log(record);
				                                        if(parseInt(record.get('nivel')) == 1){
					                                        metaData.style = "padding: 0px; margin: 0px";
					                                        var shi_codigo=record.get('shi_codigo');
					                                        var id_lote=record.get('id_lote');
					                                        return global.permisos({
					                                            type: 'link',
					                                            id_menu: control.id_menu,
					                                            icons:[
					                                                {id_serv: 2, img: '1315404769_gear_wheel.png', qtip: 'Cerrar Control.', js: "control.setCerrarEscaneado('X',"+shi_codigo+","+id_lote+")"},
					                                                {id_serv: 2, img: 'menu-16.png', qtip: 'Reprocesar.', js: "control.setCerrarEscaneado('R',"+shi_codigo+","+id_lote+")"}
					                                            ]
					                                        });
					                                    }else{
				                                        	return '';
				                                        }
				                                    }
				                                }
									        ],
					                        /*viewConfig: {
					                            stripeRows: true,
					                            enableTextSelection: false,
					                            markDirty: false
					                        },*/
					                        hideItemsReadFalse: function () {
											    var me = this,
											        items = me.getReferences().treelistRef.itemMap;


											    for(var i in items){
											        if(items[i].config.node.data.read == false){
											            items[i].destroy();
											        }
											    }
											},
					                        trackMouseOver: false,
					                        listeners:{
					                            afterrender: function(obj){
					                                //control.getImagen('default.png');
					                                
					                            },
												beforeselect:function(obj, record, index, eOpts ){
													control.shi_codigo=record.get('shi_codigo');
													control.id_det=record.get('id_det');
													control.id_lote=record.get('id_lote');
													control.getReloadPage();
												}
					                        }
					                    }
									]
								}
							]
						},
						{
							region:'center',
							layout:'border',
							border:true,
							padding:'5px 5px 5px 5px',
							items:[
								{
									region:'north',
									border:false,
									height:60,
									padding:'5px 20px 5px 20px',
									bodyStyle: 'background: transparent',
									layout: 'hbox',
									items:[
										{
						                    xtype: 'button',
						                    icon: '/images/icon/if_69_111122.png',
						                    flex:1,
						                    //glyph: 72,
						                    scale: 'large',
						                    margin:'5px 5px 5px 5px',
						                    //height:50
						                    text: 'Zoom(+)'
						                    //iconAlign: 'top'
						                },
						                {
						                    xtype: 'button',
						                    icon: '/images/icon/if_68_111123.png',
						                    flex:1,
						                    //glyph: 72,
						                    scale: 'large',
						                    margin:'5px 5px 5px 5px',
						                    //height:50
						                    text: 'Zoom(-)'
						                    //iconAlign: 'top'
						                },
						                {
						                    xtype: 'button',
						                    icon: '/images/icon/if_153_111058.png',
						                    flex:1,
						                    //glyph: 72,
						                    scale: 'large',
						                    margin:'5px 5px 5px 5px',
						                    //height:50
						                    text: 'Máximizar',
						                    //iconAlign: 'top'
						                },
						                {
						                    xtype: 'button',
						                    icon: '/images/icon/if_152_111059.png',
						                    flex:1,
						                    //glyph: 72,
						                    scale: 'large',
						                    margin:'5px 5px 5px 5px',
						                    //height:50
						                    text: 'Minimizar',
						                    //iconAlign: 'top'
						                },
						                {
						                    xtype: 'button',
						                    icon: '/images/icon/if_icons_update_1564533.png',
						                    flex:1,
						                    //glyph: 72,
						                    scale: 'large',
						                    margin:'5px 5px 5px 5px',
						                    //height:50
						                    text: 'Rotar'
						                    //iconAlign: 'top'
						                },
						                {
						                    xtype: 'button',
						                    icon: '/images/icon/if_24_111010.png',
						                    flex:1,
						                    //glyph: 72,
						                    scale: 'large',
						                    margin:'5px 5px 5px 5px',
						                    //height:50
						                    text: 'Guardar'
						                    //iconAlign: 'top'
						                },
						                {
						                    xtype: 'button',
						                    icon: '/images/icon/if_90_111056.png',
						                    flex:1,
						                    scale: 'large',
						                    //glyph: 72,
						                    margin:'5px 5px 5px 5px',
						                    //text: '[Delete]',
						                    text: 'Eliminar'
						                    //iconAlign: 'top'
						                },
						                {
						                    xtype: 'button',
						                    icon: '/images/icon/if_122_111086.png',
						                    flex:1,
						                    //glyph: 72,
						                    scale: 'large',
						                    margin:'5px 5px 5px 5px',
						                    //height:50
						                    text: 'Cortar'
						                    //iconAlign: 'top'
						                }
									]
								},
								{
									region:'center',
									id: control.id+'-panel_img',
									border:true,
									autoScroll:true,
									padding:'5px 5px 5px 5px',
									html: '<div id="imagen-control" style="width:100%; height:"100%;overflow: none;" ><img id="imagen-control-xim" src="/plantillas/Document-Scanning-Indexing-Services-min.jpg" width="100%" height="100%"/></div>'
								},
								{
									region:'south',
									title:'Texto Página - OCR',
									height:100,
									border:false,
									layout:'fit',
									items:[
										{
	                                        xtype: 'textarea',	
	                                        //fieldLabel: 'Texto',
	                                        id:control.id+'-txt-texto-pagina',
	                                        labelWidth:0,
	                                        //maskRe: /[0-9]/,
	                                        readOnly:true,
	                                        labelAlign:'right',
	                                        width:'100%',
	                                        anchor:'100%'
	                                    }
									]
								}
							]
						},
						{
							region:'west',
							border:true,
							width:300,
							layout:'border',
							border:true,
							padding:'5px 5px 5px 5px',
							items:[
								{
									region:'north',
									hidden:true,
									border:true,
									height:60,
									padding:'5px 5px 5px 5px',
									bodyStyle: 'background: transparent',
									layout: 'hbox',
									items:[
										{
						                    xtype: 'button',
						                    icon: '/images/icon/if_BT_file_text_plus_905568.png',
						                    flex:1,
						                    //glyph: 72,
						                    scale: 'large',
						                    margin:'5px 5px 5px 5px',
						                    //height:50
						                    text: 'Pág.(0)',
						                    //iconAlign: 'top'
						                },
						                {
						                    xtype: 'button',
						                    icon: '/images/icon/if_BT_file_text_minus_905569.png',
						                    flex:1,
						                    //glyph: 72,
						                    scale: 'large',
						                    margin:'5px 5px 5px 5px',
						                    //height:50
						                    text: 'Error.(0)',
						                    //iconAlign: 'top'
						                },
						                {
						                    xtype: 'button',
						                    icon: '/images/icon/if_BT_binder_905575.png',
						                    flex:1,
						                    //glyph: 72,
						                    scale: 'large',
						                    margin:'5px 5px 5px 5px',
						                    //height:50
						                    text: 'Total.(0)',
						                    //iconAlign: 'top'
						                },
									]
								},
								{
									region:'center',
									layout:'border',
									border:true,
									padding:'5px 5px 5px 5px',
									items:[
										{
											region:'center',
											border:false,
											layout:'fit',
											tbar:[
												{
									                 xtype : 'progressbar',
									                 id:control.id + '-progressbar',
									                 itemId : 'progressbar_searchresults',
									                 width : '99%',
									                 /*style: {
									                     color: 'green'
									                 },*/
									                 hidden : true,
									                 //textEl : 'progressbar_textElement',
									                 listeners:{
									                 	update:function(obj){
													        //You can handle this event at each progress interval if
													        //needed to perform some other action
													       	//Ext.fly('p3text').dom.innerHTML += '.';
													       	var punto='.';
													       	if(control.trabajando==2){
													       		punto='..';
													       	}else if(control.trabajando==3){
													       		punto='...';
													       		control.trabajando=0;
													       	}
													       	control.trabajando+=1;
													       	obj.setTextTpl('Trabajando '+punto); 
													    }
									                 }
									             }
											],
											items:[
												{
							                        xtype: 'grid',
							                        id: control.id + '-grid-paginas',
							                        store: store_paginas,
							                        columnLines: true,
							                        columns:{
							                            items:[
							                                {
							                            		text: 'N°',
															    xtype: 'rownumberer',
															    width: 40,
															    sortable: false,
															    locked: true
															},
							                                {
							                                    text: 'Descripción',
							                                    dataIndex: 'file',
							                                    flex: 1
							                                },
							                                {
							                                    text: 'OCR',
							                                    dataIndex: 'ocr',
							                                    width: 50,
							                                    align: 'center',
							                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
							                                        //console.log(record);
							                                        metaData.style = "padding: 0px; margin: 0px";
							                                        var estado = (record.get('ocr')=='N')?'check-circle-black-16.png':'check-circle-green-16.png';
							                                        var qtip = (record.get('ocr')=='Y')?'Con OCR':'Sin OCR';
							                                        return global.permisos({
							                                            type: 'link',
							                                            id_menu: control.id_menu,
							                                            icons:[
							                                                {id_serv: 2, img: estado, qtip: qtip, js: ""}
							                                            ]
							                                        });
							                                    }
							                                },
							                                {
							                                    text: 'DLT',
							                                    dataIndex: 'estado',
							                                    //loocked : true,
							                                    width: 50,
							                                    align: 'center',
							                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
							                                        //console.log(record);
							                                        metaData.style = "padding: 0px; margin: 0px";
							                                        return global.permisos({
							                                            type: 'link',
							                                            id_menu: control.id_menu,
							                                            icons:[
							                                                {id_serv: 2, img: 'recicle_nov.ico', qtip: 'Click para Desactivar Lote.', js: "control.setRemoveFile(false)"},
							                                                {id_serv: 2, img: 'if_SVG_LINE.png', qtip: 'Pasar OCR.', js: "control.setRemoveFile(false)"}
							                                            ]
							                                        });
							                                    }
							                                }
							                            ],
							                            defaults:{
							                                menuDisabled: true
							                            }
							                        },
							                        viewConfig: {
							                            stripeRows: true,
							                            enableTextSelection: false,
							                            markDirty: false
							                        },
							                        trackMouseOver: false,
							                        listeners:{
							                            afterrender: function(obj){
							                                
							                            },
							                            beforeselect:function(obj, record, index, eOpts ){
							                            	console.log(record);
							                            	document.getElementById('imagen-control').innerHTML='<img id="imagen-control-xim" src="'+record.get('path')+record.get('file')+'" width="100%" height="100%"/>'
							                            }
							                        }
							                    }
											]
										},
										{
											region:'south',
											id:control.id+'-panel-imagen-trazo',
											border:false,
											height:300,
											bbar:[
												{
			                                        xtype: 'textarea',	
			                                        //fieldLabel: 'Texto',
			                                        id:control.id+'-txt-texto-trazo',
			                                        labelWidth:0,
			                                        //maskRe: /[0-9]/,
			                                        readOnly:true,
			                                        labelAlign:'right',
			                                        width:'100%',
			                                        anchor:'100%',
			                                        height:60
			                                    }
											],
											tbar:[
												{
							                        xtype:'button',
							                        id:control.id+'-btn-ocr',
							                        //disabled:true,
							                        scale: 'large',
							                        //iconAlign: 'top',
							                        //disabled:true,
							                        width:'99%',
                                                    anchor:'99%',
							                        text: 'Procesar todo con OCR',
							                        icon: '/images/icon/if_SVG_LINE_TECHNOLOGY-01_2897334.png',
							                        listeners:{
							                            beforerender: function(obj, opts){
							                                /*global.permisos({
							                                    id: 15,
							                                    id_btn: obj.getId(), 
							                                    id_menu: gestion_devolucion.id_menu,
							                                    fn: ['panel_asignar_gestion.limpiar']
							                                });*/
							                            },
							                            click: function(obj, e){
							                            	//scanning.work=!scanning.work;
							                            	control.setProcessingOCR();
							                            }
							                        }
							                    }
											],
											html: '<img id="imagen-trazo-control" src="" style="width:100%;overflow: scroll;" />'
										}
									]
								}
							]
						}
					]
				});
				tab.add({
					id:control.id+'-tab',
					border:false,
					autoScroll:true,
					closable:true,
					layout:{
						type:'border'
					},
					items:[
						panel
					],
					listeners:{
						beforerender: function(obj, opts){
	                        global.state_item_menu(control.id_menu, true);
	                    },
	                    afterrender: function(obj, e){
	                        tab.setActiveTab(obj);
	                        global.state_item_menu_config(obj,control.id_menu);
	                        //control.getImg_tiff('escaneado');
	                    },
	                    beforeclose:function(obj,opts){
	                    	global.state_item_menu(control.id_menu, false);
	                    }
					}

				}).show();
			},
			getLoader:function(bool){
				if(bool){
					Ext.getCmp(control.id + '-progressbar').show();
					Ext.getCmp(control.id + '-progressbar').wait({
			            interval: 200,
			            //duration: 5000,
			            increment: 15,
			            fn:function() {
			                //btn3.dom.disabled = false;
			                //Ext.fly('p3text').update('Done');

			            }
			        });
				}else{
					Ext.getCmp(control.id + '-progressbar').setTextTpl('Finalizado'); 
					Ext.getCmp(control.id + '-progressbar').hide();
				}
			},
			setProcessingOCR:function(){
				global.Msg({
                    msg: '¿Está seguro de procesar todas las Páginas con OCR?',
                    icon: 3,
                    buttons: 3,
                    fn: function(btn){
                    	if (btn == 'yes'){
                    		Ext.getCmp(control.id+'-panel-west').el.mask('Guardando Formato Plantilla', 'x-mask-loading');
							control.getLoader(true);
							try{
						    	//Procesar OCR
						    	Ext.Ajax.request({
				                    url: control.url + 'set_list_page_trazos/',
				                    params:{
				                    	vp_id_pag:0,
				                		vp_shi_codigo:control.shi_codigo,
				                    	vp_id_det:control.id_det,
				                    	vp_id_lote:control.id_lote,
				                    	vp_ocr:'N'
				                    },
				                    success: function(response, options){
				                    	//Ext.getCmp(control.id+'-panel-trazos-form').el.unmask();
				                        var res = Ext.JSON.decode(response.responseText);
				                        if (res.error == 'OK'){
				                        	//console.log(res.data);
				                        	control.recordsToSend = [];
				                        	var countPage=Ext.getCmp(control.id + '-grid-paginas').getStore().getCount();
				                        	var countGlobal =0;

				                        	Ext.getCmp(control.id + '-grid-paginas').getStore().each(function(record, idx) {
											    if(record.get('ocr')=='N'){
											    	//console.log(record.get('path')+record.get('file'));
											    	//Ext.getCmp(control.id+'-panel-west').el.unmask();
											    	var image = document.getElementById('imagen-control-xim'); 
													var downloadingImage = new Image();
													var data=res.data;
													var id_pag= record.get('id_pag');
													//var cod_trazo= record.get('cod_trazo');
													//var id_det =record.get('id_det');
													//var id_lote =record.get('id_lote');

													downloadingImage.onload = function(){
														image.src = this.src;
														try{
															OCRAD(image,{
																numeric: false
															},
															function(text){
																text = text.replace(/(\r\n\t|\n|\r\t)/gm,"");
																text = text.replace('"',"");
																text = text.replace("'","");
																control.recordsToSend.push(Ext.apply({id_pag:id_pag,cod_trazo:0,id_det:control.id_det,id_lote:control.id_lote,text:text},id_pag));

																Ext.getCmp(control.id + '-grid-paginas').getSelectionModel().select(idx, true);
																//console.log(text);
																Ext.getCmp(control.id+'-txt-texto-pagina').setValue(text);
																var countPage=0;
																var countPageCurrent=0;
																for(var x=0;x<data.length;x++){
																	if(parseInt(id_pag) == parseInt(data[x].id_pag)){
																		countPage+=1;
																	}
																}
									                        	for(var i=0;i<data.length;i++){
									                        		if(parseInt(id_pag) == parseInt(data[i].id_pag)){
									                        			countPageCurrent+=1;
										                        		//console.log(data[i]);
										                        		//OCR.cod_trazo = parseInt(res.cod_trazo);
														                var image2 = document.getElementById('imagen-trazo-control');
																		var downloadingImage2 = new Image();
																		var n= (data[i].tipo=='S')?false:true;
																		var cod_trazo = data[i].cod_trazo;
																		var id_det = data[i].id_det;
																		var id_lote = data[i].id_lote;
																		downloadingImage2.onload = function(){
																		    image2.src = this.src;
																		    Ext.getCmp(control.id+'-panel-imagen-trazo').doLayout();
																		    //OCR.getSizeImg('/scanning/escaneado.jpg','S',{left:record.data.x,top:record.data.y,width:record.data.w,height:record.data.h},OCR.getResizeOrigin);
																		    //OCR.getTextoImage();
																		    try{
																				OCRAD(image2,{
																					numeric: n
																				},
																				function(text2){
																					text2 = text2.replace(/(\r\n\t|\n|\r\t)/gm,"");
																					text2 = text2.replace('"',"");
																					text2 = text2.replace("'","");
																					//console.log(text2);
																					control.recordsToSend.push(Ext.apply({id_pag:id_pag,cod_trazo:cod_trazo,id_det:id_det,id_lote:id_lote,text:text2},id_pag));
																					Ext.getCmp(control.id+'-txt-texto-trazo').setValue(text2);
																					if(countPage==countPageCurrent){
																						//record.set('ocr', 'Y');
																					    //page = record.get('id_pag');
																					    //record.commit();
																					    countGlobal+=1;
																					    if(countPage==countGlobal){
																					    	console.log(control.recordsToSend);
																					    	var recordsToSend = Ext.encode(control.recordsToSend);
																					    	Ext.Ajax.request({
																			                    url: control.url + 'set_ocr_pages/',
																			                    params:{
																			                    	vp_recordsToSend:recordsToSend
																			                    },
																			                    success: function(response, options){
																			                    	Ext.getCmp(control.id+'-panel-west').el.unmask();
																			                    	control.getLoader(false);
																			                        var res = Ext.JSON.decode(response.responseText);
																			                        if (res.error == 'OK'){
																			                            global.Msg({
																			                                msg: res.msn,
																			                                icon: 1,
																			                                buttons: 1,
																			                                fn: function(btn){
																			                                	record.set('ocr', 'Y');
																											    //page = record.get('id_pag');
																											    record.commit();
																			                                	control.getReloadPage();
																			                                }
																			                            });
																			                        } else{
																			                            global.Msg({
																			                                msg: res.msn,
																			                                icon: 0,
																			                                buttons: 1,
																			                                fn: function(btn){
																			                                	record.set('ocr', 'N');
																											    //page = record.get('id_pag');
																											    record.commit();
																			                                    control.getReloadPage();
																			                                }
																			                            });
																			                        }
																			                    }
																			                });
																					    }
																				    }
																				});
																			}catch(err) {
																			    console.log(err.message);
																			}
																		};
																		downloadingImage2.src = /tmp_trazos/ + data[i].id_pag+'-'+data[i].cod_trazo+'-trazo.'+data[i].extension;
																	}
									                        	};
															});
														}catch(err) {
														    console.log(err.message);
														}
							                        };
							                        downloadingImage.src = record.get('path')+record.get('file');
											    }
											});
				                        }else{
				                            global.Msg({
				                                msg: res.msn,
				                                icon: 0,
				                                buttons: 1,
				                                fn: function(btn){
				                                    //control.getReloadGridOCRTRAZOS(OCR.cod_plantilla);
				                                    Ext.getCmp(control.id+'-panel-west').el.unmask();
													control.getLoader(false);
				                                }
				                            });
				                        }
				                    }
				                });
							}catch(err){
								global.Msg({
	                                msg: err.message,
	                                icon: 0,
	                                buttons: 1,
	                                fn: function(btn){
	                                    Ext.getCmp(control.id+'-panel-west').el.unmask();
										control.getLoader(false);
	                                }
	                            });
							}
						}
					}
				});
			},
			setCerrarEscaneado:function(vp_op,shi_codigo,id_lote){
				if(parseInt(shi_codigo)==0){ 
					global.Msg({msg:"Seleccione un Cliente por favor.",icon:2,fn:function(){}});
					return false;
				}
				if(parseInt(id_lote)==0){
					global.Msg({msg:"Seleccione un Lote.",icon:2,fn:function(){}});
					return false;
				}

				global.Msg({
                    msg: (vp_op=='X')?'¿Seguro de cerrar Lote?':'Seguro de Enviar a Reproceso?',
                    icon: 3,
                    buttons: 3,
                    fn: function(btn){
                    	if (btn == 'yes'){
                    		Ext.getCmp(control.id+'-form').el.mask('Cerrando Lote…', 'x-mask-loading');
	                        control.getLoader(true);
			                Ext.Ajax.request({
			                    url:control.url+'set_lotizer/',
			                    params:{
			                    	vp_op:vp_op,
			                    	vp_shi_codigo:shi_codigo,
			                    	vp_id_lote:id_lote
			                    },
			                    success: function(response, options){
			                        Ext.getCmp(control.id+'-form').el.unmask();
			                        var res = Ext.JSON.decode(response.responseText);
			                        control.getLoader(false);
			                        //scanning.setLibera();
			                        if (res.error == 'OK'){
			                            global.Msg({
			                                msg: res.msn,
			                                icon: 1,
			                                buttons: 1,
			                                fn: function(btn){
			                                	control.getReloadGridcontrol();
			                                	control.getReloadPage();
			                                }
			                            });
			                        } else{
			                            global.Msg({
			                                msg: res.msn,
			                                icon: 0,
			                                buttons: 1,
			                                fn: function(btn){
			                                	control.getReloadGridcontrol();
			                                	control.getReloadPage();
			                                }
			                            });
			                        }
			                    }
			                });
						}
					}
				});

			},
			getReloadPage:function(){
				control.id_pag=0;
				Ext.getCmp(control.id + '-grid-paginas').getStore().removeAll();
				Ext.getCmp(control.id + '-grid-paginas').getStore().load({
                	params:{
                		vp_id_pag:0,
                		vp_shi_codigo:control.shi_codigo,
                    	vp_id_det:control.id_det,
                    	vp_id_lote:control.id_lote
	                },
	                callback:function(){
	                	//Ext.getCmp(scanning.id+'-form').el.unmask();
	                	//control.setChangeRow();
	                }
	            });
			},
			renderTip:function(val, meta, rec, rowIndex, colIndex, store) {
			    // meta.tdCls = 'cell-icon'; // icon
			    meta.tdAttr = 'data-qtip="'+val+'"';
			    return val;
			},
			onMaxAllClick: function(){
		        Ext.suspendLayouts();
		        this.items.each(function(c){
		            c.setValue(100);
		        });
		        Ext.resumeLayouts(true);
		    },
		    
		    onSaveClick: function(){
		        Ext.Msg.alert({
		            title: 'Settings Saved',
		            msg: this.msgTpl.apply(this.getForm().getValues()),
		            icon: Ext.Msg.INFO,
		            buttons: Ext.Msg.OK
		        }); 
		    },
		    
		    onResetClick: function(){
		        this.getForm().reset();
		    },
			getImagen:function(param){
				win.getGalery({container:'GaleryFull',width:390,height:250,params:{forma:'F',img_path:'/control/'+param}});
			},
			setcontrol:function(op){

				global.Msg({
                    msg: '¿Está seguro de guardar?',
                    icon: 3,
                    buttons: 3,
                    fn: function(btn){
                        Ext.getCmp(control.id+'-form').el.mask('Cargando…', 'x-mask-loading');

						Ext.getCmp(control.id+'-form-info').submit({
		                    url: control.url + 'setRegisterCampana/',
		                    params:{
		                        vp_op: control.opcion,
		                        vp_shi_codigo:control.cod_cam,
		                        vp_shi_nombre:Ext.getCmp(control.id+'-txt-nombre').getValue(),
		                        vp_shi_descripcion:Ext.getCmp(control.id+'-txt-descripcion').getValue(),
		                        vp_fec_ingreso:Ext.getCmp(control.id+'-date-re').getRawValue(),
		                        vp_estado:Ext.getCmp(control.id+'-cmb-estado').getValue()
		                    },
		                    success: function( fp, o ){
		                    	//console.log(o);
		                        var res = o.result;
		                        Ext.getCmp(control.id+'-form').el.unmask();
		                        //console.log(res);
		                        if (parseInt(res.error) == 0){
		                            global.Msg({
		                                msg: res.data,
		                                icon: 1,
		                                buttons: 1,
		                                fn: function(btn){
		                                    control.getReloadGridcontrol();
		                                    control.setNuevo();
		                                }
		                            });
		                        } else{
		                            global.Msg({
		                                msg: 'Ocurrio un error intentalo nuevamente.',
		                                icon: 0,
		                                buttons: 1,
		                                fn: function(btn){
		                                    control.getReloadGridcontrol();
		                                    control.setNuevo();
		                                }
		                            });
		                        }
		                    }
		                });
		            }
                });
			},
			getContratos:function(shi_codigo){
				Ext.getCmp(control.id+'-cbx-contrato').getStore().removeAll();
				Ext.getCmp(control.id+'-cbx-contrato').getStore().load(
	                {params: {vp_shi_codigo:shi_codigo},
	                callback:function(){
	                	//Ext.getCmp(control.id+'-form').el.unmask();
	                }
	            });
			},
			getReloadGridcontrol:function(){
				//control.set_control_clear();
				//Ext.getCmp(control.id+'-form').el.mask('Cargando…', 'x-mask-loading');
				var shi_codigo = Ext.getCmp(control.id+'-cbx-cliente').getValue();
				var fac_cliente = Ext.getCmp(control.id+'-cbx-contrato').getValue();
				var lote = Ext.getCmp(control.id+'-txt-lote').getValue();
				var name = Ext.getCmp(control.id+'-txt-control').getValue();
				var estado = 'A';//Ext.getCmp(control.id+'-txt-estado-filter').getValue();
				var fecha = Ext.getCmp(control.id+'-txt-fecha-filtro').getRawValue();

				if(shi_codigo== null || shi_codigo==''){
		            global.Msg({msg:"Seleccione un Cliente por favor.",icon:2,fn:function(){}});
		            return false;
		        }
				if(fac_cliente== null || fac_cliente==''){
		            global.Msg({msg:"Seleccione un Contrato por favor.",icon:2,fn:function(){}});
		            return false;
		        }
		        if(lote== null || lote==''){
		        	lote=0;
		        }
				if(fecha== null || fecha==''){
		            global.Msg({msg:"Ingrese una fecha de busqueda por favor.",icon:2,fn:function(){}});
		            return false;
		        }
				Ext.getCmp(control.id + '-grid').getStore().load(
	                {params: {vp_shi_codigo:shi_codigo,vp_fac_cliente:fac_cliente,vp_lote:lote,vp_lote_estado:'CO',vp_name:name,fecha:fecha,vp_estado:estado},
	                callback:function(){
	                	//Ext.getCmp(control.id+'-form').el.unmask();
	                }
	            });
			},
			setNuevo:function(){
				control.shi_codigo=0;
				control.getImagen('default.png');
				Ext.getCmp(control.id+'-txt-nombre').setValue('');
				Ext.getCmp(control.id+'-txt-descripcion').setValue('');
				Ext.getCmp(control.id+'-date-re').setValue('');
				Ext.getCmp(control.id+'-cmb-estado').setValue('');
				Ext.getCmp(control.id+'-txt-nombre').focus();
			},
			getImg_tiff: function(file){//(rec,recA){
				
				var panel = Ext.getCmp(control.id+'-panel_img');
                panel.removeAll();
                panel.add({
                    html: '<img id="imagen-control-xim" src="/scanning/'+file+'.jpg" style="width:100%; height:"100%;" >'
                });
		        /*var myMask = new Ext.LoadMask(Ext.getCmp('form-central-xim').el, {msg:"Por favor espere..."});
		        Ext.Ajax.request({
		            url: gestor_errores.url+'dig_qry_gestor_errores_detalle/',
		            params:{manifiesto:rec.get('man_id'),va_id_trama:rec.get('id_trama'),va_prov_codigo:recA.get('prov_codigo')},
		            success:function(response, options){
		                myMask.hide();
		                var file = Ext.decode(response.responseText);
		                gestor_errores.get_dat_form(file,recA);
		                var panel = Ext.getCmp(gestor_errores.id+'-panel_img');
		                panel.removeAll();
		                panel.add({
		                    html: '<img src="/imagenes/'+file.img+'.jpg" style="width:100%; height:100%;" >'
		                });
		                setTimeout("gestor_errores.delete_tiff('"+file.img+"')", 1200);
		                panel.doLayout();
		            }
		        });*/
		    },
		    delete_tiff: function(img){
		        /*Ext.Ajax.request({
		            url: gestor_errores.url+'delete_tiff/',
		            params:{img:img},
		            success:function(response, options){
		                var file = response.responseText;                
		            }
		        });*/
		    },
		    get_error_sel: function(rec_01){
		        /*var grid = Ext.getCmp(gestor_err.id+'-grid');
		        var rec = grid.getSelectionModel().getSelected();
		        gestor_errores.getImg_tiff(rec_01,rec);*/
		    },
		    setLimpiar:function(){
		        /*var panel = Ext.getCmp(gestor_errores.id+'-panel_img');
		        panel.removeAll();        
		        panel.doLayout();*/
		    }
		}
		Ext.onReady(control.init,control);
	}else{
		tab.setActiveTab(control.id+'-tab');
	}
</script>