<script type="text/javascript">
	var tab = Ext.getCmp(inicio.id+'-tabContent');
	if(!Ext.getCmp('lotizer-tab')){
		var lotizer = {
			id:'lotizer',
			id_menu:'<?php echo $p["id_menu"];?>',
			url:'/gestion/lotizer/',
			opcion:'I',
			id_lote:0,
			init:function(){
				Ext.tip.QuickTipManager.init();

				Ext.define('Task', {
				    extend: 'Ext.data.TreeModel',
				    fields: [
				        {name: 'id_lote', type: 'string'},
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
	                    url: lotizer.url+'get_list_lotizer/'//,
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
	                 		Ext.getCmp(lotizer.id + '-grid').doLayout();
	                 		//Ext.getCmp(lotizer.id + '-grid').getView().getRow(0).style.display = 'none';
	                 		storeTree.removeAt(0);
	                 		Ext.getCmp(lotizer.id + '-grid').collapseAll();
		                    Ext.getCmp(lotizer.id + '-grid').getRootNode().cascadeBy(function (node) {
		                          if (node.getDepth() < 1) { node.expand(); }
		                          if (node.getDepth() == 0) { return false; }
		                     });
	                    }
	                }
	            });
				var store = Ext.create('Ext.data.Store',{
                fields: [
                    {name: 'id_lote', type: 'string'},
                    {name: 'tipdoc', type: 'string'},
                    {name: 'nombre', type: 'string'},
                    {name: 'fecha', type: 'string'},
                    {name: 'tot_folder', type: 'string'},                    
                    {name: 'id_user', type: 'string'},                    
                    {name: 'estado', type: 'string'}
                ],
                autoLoad:false,
                proxy:{
                    type: 'ajax',
                    url: lotizer.url+'get_list_lotizer/',
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
                    {name: 'nombre', type: 'string'},
                    {name: 'id_det', type: 'string'},
                    {name: 'fecha', type: 'string'},
                    {name: 'tot_pag', type: 'string'},                    
                    {name: 'tot_pag_err', type: 'string'},
                    {name: 'estado', type: 'string'}
                ],
                autoLoad:true,
                proxy:{
                    type: 'ajax',
                    url: lotizer.url+'get_lotizer_detalle/',
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
			var myData = [
			    ['L','Lotizer'],
			    ['S','Scan']
			];
			var store_estado = Ext.create('Ext.data.ArrayStore', {
		        storeId: 'estado',
		        autoLoad: true,
		        data: myData,
		        fields: ['code', 'name']
		    });

		    var myDataLote = [
				['L','Activo'],
			    ['E','Inactivo']
			];
			var store_estado_lote = Ext.create('Ext.data.ArrayStore', {
		        storeId: 'estado',
		        autoLoad: true,
		        data: myDataLote,
		        fields: ['code', 'name']
		    });

				var panel = Ext.create('Ext.form.Panel',{
					id:lotizer.id+'-form',
					bodyStyle: 'background: transparent',
					border:false,
					layout:'border',
					defaults:{
						border:false
					},
					tbar:[],
					items:[
						
						
					]
				});
				tab.add({
					id:lotizer.id+'-tab',
					border:false,
					autoScroll:true,
					closable:true,
					layout:'border',
					items:[
						{
                            region:'north',
                            border:false,
                            xtype: 'uePanelS',
                            logo: 'CL',
                            title: 'Listado de Lotes',
                            legend: 'Búsqueda de Lotes registrados',
                            height:90,
                            items:[
                                {
                                    xtype:'panel',
                                    border:false,
                                    bodyStyle: 'background: transparent',
                                    padding:'2px 5px 1px 5px',
                                    layout:'column',
                                    items: [
                                        {
                                            width:600,border:false,
                                            padding:'0px 2px 0px 0px',  
                                            bodyStyle: 'background: transparent',
                                            items:[
                                                {
                                                    xtype: 'textfield',	
                                                    fieldLabel: 'Lotes',
                                                    id:lotizer.id+'-txt-lotizer',
                                                    labelWidth:50,
                                                    //readOnly:true,
                                                    labelAlign:'right',
                                                    width:'100%',
                                                    anchor:'100%'
                                                }
                                            ]
                                        },
                                        {
	                                        width: 160,border:false,
	                                        padding:'0px 2px 0px 0px',  
	                                    	bodyStyle: 'background: transparent',
	                                        items:[
	                                            {
	                                                xtype:'datefield',
	                                                id:lotizer.id+'-txt-fecha-filtro',
	                                                fieldLabel:'Fecha',
	                                                labelWidth:60,
	                                                labelAlign:'right',
	                                                value:new Date(),
	                                                format: 'Ymd',
	                                                //readOnly:true,
	                                                width: '100%',
	                                                anchor:'100%'
	                                            }
	                                        ]
	                                    },
                                        {
	                                   		width: 150,border:false,
	                                    	padding:'0px 2px 0px 0px',  
	                                    	bodyStyle: 'background: transparent',
	                                 		items:[
	                                                {
	                                                    xtype:'combo',
	                                                    fieldLabel: 'Estado',
	                                                    id:lotizer.id+'-txt-estado-filter',
	                                                    store: store_estado_lote,
	                                                    queryMode: 'local',
	                                                    triggerAction: 'all',
	                                                    valueField: 'code',
	                                                    displayField: 'name',
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
	                                                            Ext.getCmp(lotizer.id+'-txt-estado-filter').setValue('L');
	                                                        },
	                                                        select:function(obj, records, eOpts){
	                                                
	                                                        }
	                                                    }
	                                                }
	                                 		]
	                                    },
                                        {
                                            width: 80,border:false,
                                            padding:'0px 2px 0px 0px',  
                                            bodyStyle: 'background: transparent',
                                            items:[
                                                {
							                        xtype:'button',
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
							                            	var name = Ext.getCmp(lotizer.id+'-txt-lotizer').getValue();
                               					            lotizer.getReloadGridlotizer(name);
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
							//width:'100%',
							layout:'border',
							items:[
								{
									region:'north',
									border:false,
									height:70,
									items:[
										{
	                                        xtype: 'fieldset',
	                                        margin: '5 5 5 10',
	                                        title:'<b>Mantenimiento Lotes</b>',
	                                        border:true,
	                                        bodyStyle: 'background: transparent',
	                                        padding:'2px 5px 1px 5px',
	                                        layout:'column',
	                                        items: [
	                                            {
	                                                columnWidth: .2,border:false,
	                                                padding:'10px 2px 0px 0px',  bodyStyle: 'background: transparent',
	                                                items:[
	                                                    {
	                                                        xtype: 'textfield',
	                                                        fieldLabel: 'Nombre',
	                                                        id:lotizer.id+'-txt-nombre',
	                                                        labelWidth:60,
	                                                        //readOnly:true,
	                                                        labelAlign:'right',
	                                                        width:'100%',
	                                                        anchor:'100%'
	                                                    }
	                                                ]
	                                            },
	                                            {
	                                                columnWidth: .3,border:false,
	                                                padding:'10px 2px 0px 0px',  bodyStyle: 'background: transparent',
	                                                items:[
	                                                    {
	                                                        xtype: 'textfield',
	                                                        fieldLabel: 'Descripción',
	                                                        id:lotizer.id+'-txt-descripcion',
	                                                        labelWidth:70,
	                                                        //readOnly:true,
	                                                        labelAlign:'right',
	                                                        width:'100%',
	                                                        anchor:'100%'
	                                                    }
	                                                ]
	                                            },
	                                            {
	                                                width: 150,border:false,
	                                                padding:'10px 2px 0px 0px',  bodyStyle: 'background: transparent',
	                                                items:[
	                                                    {
	                                                        xtype: 'textfield',
	                                                        fieldLabel: 'Total Folders',
	                                                        id:lotizer.id+'-txt-tot_folder',
	                                                        labelWidth:100,
	                                                        //readOnly:true,
	                                                        labelAlign:'right',
	                                                        maskRe: /[0-9]/,
	                                                        width:'100%',
	                                                        anchor:'100%'
	                                                    }
	                                                ]
	                                            },
	                                            {
	                                                width: 1,border:false,hidden:true,
	                                                padding:'10px 2px 0px 0px',  bodyStyle: 'background: transparent',
	                                                items:[
	                                                    {
	                                                        xtype: 'textfield',
	                                                        fieldLabel: 'Tipo Doc',
	                                                        id:lotizer.id+'-txt-tipdoc',
	                                                        labelWidth:100,
	                                                        readOnly:true,
	                                                        labelAlign:'right',
	                                                        width:'100%',
	                                                        anchor:'100%'
	                                                    }
	                                                ]
	                                            },

	                                            {
	                                                width: 160,border:false,hidden:true,
	                                                padding:'10px 2px 0px 0px',  bodyStyle: 'background: transparent',
	                                                items:[
	                                                    {
	                                                        xtype:'datefield',
	                                                        id:lotizer.id+'-txt-fecha',
	                                                        fieldLabel:'Fecha',
	                                                        labelWidth:60,
	                                                        labelAlign:'right',
	                                                        value:new Date(),
	                                                        format: 'Ymd',
	                                                        readOnly:true,
	                                                        width: '100%',
	                                                        anchor:'100%'
	                                                    }
	                                                ]
	                                            },
	                                            {
                                               		width: 150,border:false,
                                                	padding:'10px 2px 0px 0px',  bodyStyle: 'background: transparent',
                                             		items:[
		                                                    {
		                                                        xtype:'combo',
		                                                        fieldLabel: 'Estado',
		                                                        id:lotizer.id+'-txt-estado',
		                                                        store: store_estado_lote,
		                                                        queryMode: 'local',
		                                                        triggerAction: 'all',
		                                                        valueField: 'code',
		                                                        displayField: 'name',
		                                                        emptyText: '[Seleccione]',
		                                                        labelAlign:'right',
		                                                        //allowBlank: false,
		                                                        labelWidth: 60,
		                                                        width:'100%',
		                                                        anchor:'100%',
		                                                        //readOnly: true,
		                                                        listeners:{
		                                                            afterrender:function(obj, e){
		                                                                // obj.getStore().load();
		                                                                Ext.getCmp(lotizer.id+'-txt-estado').setValue('L');
		                                                            },
		                                                            select:function(obj, records, eOpts){
		                                                    
		                                                            }
		                                                        }
		                                                    }
                                             		]
                                                },
                                                {
													id: lotizer.id + '-grabar',
													margin:'10px 2px 0px 0px',  bodyStyle: 'background: transparent',
							                        xtype:'button',
							                        width:80,
							                        text: 'Grabar',
							                        icon: '/images/icon/save.png',
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
															lotizer.set_lotizer(3,'¿Está seguro de guardar?');

							                            }
							                        }
							                    },
							                    {
													id: lotizer.id + '-cancelar',
													margin:'10px 2px 0px 0px',  bodyStyle: 'background: transparent',
							                        xtype:'button',
							                        width:80,
							                        text: 'Limpiar',
							                        icon: '/images/icon/broom.png',
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
															lotizer.set_lotizer_clear();
							                            }
							                        }
							                    }
	                                            
	                                        ]
	                                    }
									]
								},
								{
									region:'center',
									border:false,
									layout:'fit',
									items:[
										{
					                        xtype: 'treepanel',
					                        //collapsible: true,
									        useArrows: true,
									        rootVisible: true,
									        multiSelect: true,
									        //root:'Task',
					                        id: lotizer.id + '-grid',
					                        //height: 370,
					                        //reserveScrollbar: true,
					                        //rootVisible: false,
					                        //store: store,
					                        //layout:'fit',
					                        columnLines: true,
					                        store: storeTree,
								            columns: [
									            /*{
									                xtype: 'treecolumn', //this is so we know which column will show the tree
									                text: 'Task',
									                flex: 2,
									                sortable: true,
									                dataIndex: 'task'
									            },*/
									            {
									            	xtype: 'treecolumn',
				                                    text: 'Nombre',
				                                    dataIndex: 'lote_nombre',
				                                    sortable: true,
				                                    flex: 1
				                                },
				                                {
				                                    text: 'Descripción',
				                                    dataIndex: 'descripcion',
				                                    flex: 2
				                                },
				                                {
				                                    text: 'Fecha y Hora',
				                                    dataIndex: 'fecha',
				                                    width: 180,
				                                    align: 'center'
				                                },
				                                {
				                                    text: 'Total Folder',
				                                    dataIndex: 'tot_folder',
				                                    width: 80,
				                                    align: 'center'
				                                },
				                                {
				                                    text: 'Total Página',
				                                    dataIndex: 'tot_pag',
				                                    width: 80,
				                                    align: 'center'
				                                },
				                                {
				                                    text: 'Total Pag. Errores',
				                                    dataIndex: 'tot_errpag',
				                                    width: 100,
				                                    align: 'center'
				                                },
				                                {
				                                    text: 'User',
				                                    dataIndex: 'usr_update',
				                                    width: 100,
				                                    align: 'center'
				                                },
				                                {
				                                    text: 'Estado',
				                                    dataIndex: 'estado',
				                                    loocked : true,
				                                    width: 50,
				                                    align: 'center',
				                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
				                                        //console.log(record);
				                                        metaData.style = "padding: 0px; margin: 0px";
				                                        var estado = (record.get('estado')=='L')?'check-circle-green-16.png':'check-circle-red.png';
				                                        var qtip = (record.get('estado')=='L')?'Estado del Lote Activo.':'Estado del Lote Inactivo.';
				                                        return global.permisos({
				                                            type: 'link',
				                                            id_menu: lotizer.id_menu,
				                                            icons:[
				                                                {id_serv: 1, img: estado, qtip: qtip, js: ""}
				                                            ]
				                                        });
				                                    }
				                                },
				                                {
				                                    text: 'Editar',
				                                    dataIndex: 'estado',
				                                    //loocked : true,
				                                    width: 50,
				                                    align: 'center',
				                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
				                                        //console.log(record);
				                                        if(parseInt(record.get('nivel')) == 1){
					                                        metaData.style = "padding: 0px; margin: 0px";
					                                        return global.permisos({
					                                            type: 'link',
					                                            id_menu: lotizer.id_menu,
					                                            icons:[
					                                                {id_serv: 1, img: 'ico_editar.gif', qtip: 'Click para Editar Lote.', js: "lotizer.setEditLote("+rowIndex+",'U')"},
					                                                {id_serv: 1, img: 'recicle_nov.ico', qtip: 'Click para Desactivar Lote.', js: "lotizer.setEditLote("+rowIndex+",'D')"}
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
					                                //lotizer.getImagen('default.png');
					                                
					                            },
												beforeselect:function(obj, record, index, eOpts ){
													//console.log(record);
													/*lotizer.opcion='U';*/
													/*lotizer.id_lote=record.get('id_lote');
													/*lotizer.getImagen(record.get('imagen'));*/
													/*Ext.getCmp(lotizer.id+'-txt-nombre').setValue(record.get('nombre'));
													Ext.getCmp(lotizer.id+'-txt-tipdoc').setValue(record.get('tipdoc'));
													Ext.getCmp(lotizer.id+'-txt-fecha').setValue(record.get('fecha'));
													Ext.getCmp(lotizer.id+'-txt-estado').setValue(record.get('estado'));
													Ext.getCmp(lotizer.id+'-txt-tot_folder').setValue(record.get('tot_folder'));

													Ext.getCmp(lotizer.id+'-txt-nombre').setReadOnly(true);
													Ext.getCmp(lotizer.id+'-txt-tipdoc').setReadOnly(true);
													Ext.getCmp(lotizer.id+'-txt-fecha').setReadOnly(true);
													Ext.getCmp(lotizer.id+'-txt-estado').setReadOnly(true);
													Ext.getCmp(lotizer.id+'-txt-tot_folder').setReadOnly(true);


													var botonTxt = Ext.getCmp('boton').getText();
													if (botonTxt == 'Guardar' || botonTxt == 'Update') {
														Ext.getCmp('boton').setText('Editar');
														Ext.getCmp('boton').setIcon('/images/icon/editar.png');
													}*/

													//lotizer.getReloadGridlotizer2(lotizer.id_lote);

												}
					                        }
					                    }
									]
								}
							]
							
						}
					],
					listeners:{
						beforerender: function(obj, opts){
	                        global.state_item_menu(lotizer.id_menu, true);
	                    },
	                    afterrender: function(obj, e){
	                    	lotizer.getReloadGridlotizer('');
	                        tab.setActiveTab(obj);
	                        global.state_item_menu_config(obj,lotizer.id_menu);
	                    },
	                    beforeclose:function(obj,opts){
	                    	global.state_item_menu(lotizer.id_menu, false);
	                    }
					}

				}).show();
			},
			getImagen:function(param){
				/*win.getGalery({container:'GaleryFull',width:390,height:250,params:{forma:'F',img_path:'/lotizer/'+param}});*/
			},
			setEditLote:function(index,op){
				var rec = Ext.getCmp(lotizer.id + '-grid').getStore().getAt(index);
				lotizer.id_lote=rec.data.id_lote;
				lotizer.opcion=op;
				if(op!='D'){
					Ext.getCmp(lotizer.id+'-txt-nombre').setValue(rec.data.nombre);
					Ext.getCmp(lotizer.id+'-txt-descripcion').setValue(rec.data.descripcion);
				  	Ext.getCmp(lotizer.id+'-txt-estado').setValue(rec.data.estado);
				  	Ext.getCmp(lotizer.id+'-txt-tot_folder').setValue(rec.data.tot_folder);
				  	Ext.getCmp(lotizer.id+'-txt-nombre').focus(true);
					//console.log(rec.data);
				}else{
					lotizer.set_lotizer(2,'¿Está seguro de Desactivar?');
				}
			},
			set_lotizer_clear:function(){
				Ext.getCmp(lotizer.id+'-txt-nombre').setValue('');
				Ext.getCmp(lotizer.id+'-txt-descripcion').setValue('');
			  	Ext.getCmp(lotizer.id+'-txt-estado').setValue('L');
			  	Ext.getCmp(lotizer.id+'-txt-tot_folder').setValue(0);
			  	lotizer.id_lote=0;
				lotizer.opcion='I';
				Ext.getCmp(lotizer.id+'-txt-nombre').focus(true);
			},
			setValidaLote:function(){
				if(lotizer.opcion=='I'){
					var nombre = Ext.getCmp(lotizer.id+'-txt-nombre').getValue();
					if(nombre== null || nombre==''){
			            global.Msg({msg:"Ingrese un nombre por favor.",icon:2,fn:function(){}});
			            return false;
			        }
			        var estado = Ext.getCmp(lotizer.id+'-txt-estado').getValue();
			        if(estado== null || estado==''){
			            global.Msg({msg:"Ingrese un estado por favor.",icon:2,fn:function(){}});
			            return false; 
			        }
				  	var total = Ext.getCmp(lotizer.id+'-txt-tot_folder').getValue();
				  	if(total== null || total==0 || total==''){
			            global.Msg({msg:"Ingrese el total de folderes por favor.",icon:2,fn:function(){}});
			            return false;
			        }
			    }
		        return true;
			},
			set_lotizer:function(ico,msn){
				if(!lotizer.setValidaLote())return;
				global.Msg({
                    msg: msn,
                    icon: ico,
                    buttons: 3,
                    fn: function(btn){
                    	if (btn == 'yes'){
	                        Ext.getCmp(lotizer.id+'-tab').el.mask('Cargando…', 'x-mask-loading');

	                        Ext.Ajax.request({
								url: lotizer.url + 'set_lotizer/',
								params:{
									vp_op: lotizer.opcion,
			                        vp_id_lote:lotizer.id_lote,
			                        vp_nombre:Ext.getCmp(lotizer.id+'-txt-nombre').getValue(),
			                        vp_descripcion:Ext.getCmp(lotizer.id+'-txt-descripcion').getValue(),
			                        vp_tipdoc:Ext.getCmp(lotizer.id+'-txt-tipdoc').getValue(),
			                        vp_lote_fecha:Ext.getCmp(lotizer.id+'-txt-fecha').getValue(),
			                        vp_ctdad:Ext.getCmp(lotizer.id+'-txt-tot_folder').getValue(),
			                        vp_estado:Ext.getCmp(lotizer.id+'-txt-estado').getValue()
								},
								success:function(response,options){
									var res = Ext.decode(response.responseText);
									Ext.getCmp(lotizer.id+'-tab').el.unmask();
									//console.log(res);
									///*****Terrestre****//
									global.Msg({
		                                msg: res.msn,
		                                icon: parseInt(res.error),
		                                buttons: 1,
		                                fn: function(btn){
		                                    if(parseInt(res.error)==1){
		                                    	lotizer.getReloadGridlotizer('');
		                                    	lotizer.set_lotizer_clear();
		                                    }
		                                }
		                            });
				    			}
				    		});
				    	}
		            }
                });
			},
			getReloadGridlotizer:function(name){
				lotizer.set_lotizer_clear();
				//Ext.getCmp(lotizer.id+'-form').el.mask('Cargando…', 'x-mask-loading');
				var name = Ext.getCmp(lotizer.id+'-txt-lotizer').getValue();
				var estado = Ext.getCmp(lotizer.id+'-txt-estado-filter').getValue();
				var fecha = Ext.getCmp(lotizer.id+'-txt-fecha-filtro').getRawValue();
				if(fecha== null || fecha==''){
		            global.Msg({msg:"Ingrese una fecha de busqueda por favor.",icon:2,fn:function(){}});
		            return false;
		        }
				Ext.getCmp(lotizer.id + '-grid').getStore().load(
	                {params: {vp_name:name,fecha:fecha,vp_estado:estado},
	                callback:function(){
	                	//Ext.getCmp(lotizer.id+'-form').el.unmask();
	                }
	            });
			},
			getReloadGridlotizer2:function(id_lote){
				Ext.getCmp(lotizer.id+'-form').el.mask('Cargando…', 'x-mask-loading');
				//id:lotizer.id+'-form'
				Ext.getCmp(lotizer.id + '-grid-lotizer').getStore().load(
	                {params: {vp_id_lote:id_lote},
	                callback:function(){
	                	Ext.getCmp(lotizer.id+'-form').el.unmask();
	                }
	            });
			},
			setNuevo:function(){
				//lotizer.shi_codigo=0;
				//lotizer.getImagen('default.png');
//					                        icon: '/images/icon/save.png',

				Ext.getCmp(lotizer.id+'-txt-nombre').setValue('');
				Ext.getCmp(lotizer.id+'-txt-nombre').setReadOnly(false);
				Ext.getCmp(lotizer.id+'-txt-tipdoc').setValue('');
				Ext.getCmp(lotizer.id+'-txt-tipdoc').setReadOnly(false);
				Ext.getCmp(lotizer.id+'-txt-fecha').setValue('');
				Ext.getCmp(lotizer.id+'-txt-fecha').setReadOnly(false);
				Ext.getCmp(lotizer.id+'-txt-estado').setValue('');
				Ext.getCmp(lotizer.id+'-txt-estado').setReadOnly(false);
				Ext.getCmp(lotizer.id+'-txt-tot_folder').setValue('');
				Ext.getCmp(lotizer.id+'-txt-tot_folder').setReadOnly(false);
				Ext.getCmp(lotizer.id+'-txt-nombre').focus();
			},

			getFormMant:function(cod_lote,lote,usuario,cantidad){
				var myData = [
				    ['1','Activo'],
				    ['0','Inactivo']
				];
				var store_estado = Ext.create('Ext.data.ArrayStore', {
			        storeId: 'estado',
			        autoLoad: true,
			        data: myData,
			        fields: ['code', 'name']
			    });

				Ext.create('Ext.window.Window',{
	                id:lotizer.id+'-win-form',
	                plain: true,
	                title:'Edición',
	                icon: '/images/icon/edit.png',
	                height: 200,
	                width: 450,
	                resizable:false,
	                modal: true,
	                border:false,
	                closable:true,
	                padding:20,
	                items:[
	                	{
	                        xtype: 'textfield',
	                        id:lotizer.id+'-grid-lotizer-form',
	                        fieldLabel: 'Cod_Lote',
	                        //disabled:true,
	                        labelWidth:90,
	                        labelAlign:'right',
	                        width:'100%',
	                        anchor:'100%',
	                        value:cod_lote
	                    },
	                    {
	                        xtype: 'textfield',
	                        id:lotizer.id+'-form-descripcion',
	                        fieldLabel: 'Descripción',
	                        labelWidth:90,
	                        labelAlign:'right',
	                        width:'100%',
	                        anchor:'100%',
	                        value:descripcion
	                    },
	                    {
	                        xtype:'combo',
	                        fieldLabel: 'Estado',
	                        id:formularioGestion.id+'-form-cmb-estado',
	                        store: store_estado,
	                        queryMode: 'local',
	                        triggerAction: 'all',
	                        valueField: 'code',
	                        displayField: 'name',
	                        emptyText: '[Seleccione]',
	                        labelAlign:'right',
	                        //allowBlank: false,
	                        labelWidth: 90,
	                        width:'100%',
	                        anchor:'100%',
	                        //readOnly: true,
	                        listeners:{
	                            afterrender:function(obj, e){
	                                // obj.getStore().load();
	                                if(ID==0){
	                                	obj.setValue(1);
	                                }else{
	                                	obj.setValue(estado);
	                                }
	                            },
	                            select:function(obj, records, eOpts){
	                    
	                            }
	                        }
	                    }
	                ],
	                bbar:[       
	                    '->',
	                    '-',
	                    {
	                        xtype:'button',
	                        text: 'Guardar',
	                        icon: '/images/icon/save.png',
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
	                            	formularioGestion.setSaveRecordForm(ID);
	                            }
	                        }
	                    },
	                    '-',
	                    {
	                        xtype:'button',
	                        text: 'Salir',
	                        icon: '/images/icon/get_back.png',
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
	                                Ext.getCmp(formularioGestion.id+'-win-form').close();
	                            }
	                        }
	                    },
	                    '-'
	                ],
	                listeners:{
	                    'afterrender':function(obj, e){ 
	                        //panel_asignar_gestion.getDatos();
	                    },
	                    'close':function(){
	                        //if(panel_asignar_gestion.guarda!=0)gestion_devolucion.buscar();
	                    }
	                }
	            }).show().center();
			}

		}
		Ext.onReady(lotizer.init,lotizer);
	}else{
		tab.setActiveTab(lotizer.id+'-tab');
	}
</script>