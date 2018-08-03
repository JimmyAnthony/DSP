<script type="text/javascript">
	var tab = Ext.getCmp(inicio.id+'-tabContent');
	if(!Ext.getCmp('scanning-tab')){
		var scanning = {
			id:'scanning',
			id_menu:'<?php echo $p["id_menu"];?>',
			url:'/gestion/scanning/',
			opcion:'I',
			init:function(){
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
                autoLoad:true,
                proxy:{
                    type: 'ajax',
                    url: scanning.url+'get_list/?vp_cod_lote=0',
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
                    url: scanning.url+'get_sis_list_shipper_campana/',
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
					id:scanning.id+'-form',
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
							border:true,
							width:'20%',
							layout:'border',
							border:true,
							padding:'5px 5px 5px 5px',
							items:[
								{
									region:'north',
									border:true,
									height:60,
									padding:'5px 5px 5px 5px',
									bodyStyle: 'background: transparent',
									layout: 'hbox',
									items:[
										{
						                    xtype: 'button',
						                    icon: null,
						                    flex:1,
						                    glyph: 72,
						                    margin:'5px 5px 5px 5px',
						                    text: 'Guardar',
						                    iconAlign: 'top'
						                },
						                {
						                    xtype: 'button',
						                    icon: null,
						                    flex:1,
						                    glyph: 72,
						                    margin:'5px 5px 5px 5px',
						                    text: 'Actualizar',
						                    iconAlign: 'top'
						                },
						                {
						                    xtype: 'button',
						                    icon: null,
						                    flex:1,
						                    glyph: 72,
						                    margin:'5px 5px 5px 5px',
						                    text: 'Eliminar',
						                    iconAlign: 'top'
						                },
						                {
						                    xtype: 'button',
						                    icon: null,
						                    flex:1,
						                    glyph: 72,
						                    margin:'5px 5px 5px 5px',
						                    text: 'Salir',
						                    iconAlign: 'top'
						                }
									]
								},
								{
									region:'center',
									border:true,
									padding:'5px 5px 5px 5px',
									items:[
										{
									        xtype: 'fieldset',
									        title: 'Acción',
									        margin:'5px 5px 5px 5px',
									        defaults: {
									            anchor: '100%'
									        },
									        layout: 'hbox',
									        items: [
									            {
								                    xtype: 'button',
								                    icon: null,
								                    glyph: 72,
								                    width: '50%',
								                    margin:'5px 5px 5px 5px',
								                    text: 'Digitalizar',
								                    iconAlign: 'top'
								                },
								                {
								                    xtype: 'button',
								                    icon: null,
								                    glyph: 72,
								                    width: '50%',
								                    margin:'5px 5px 5px 5px',
								                    text: 'Importar Imagen',
								                    iconAlign: 'top'
								                }
									        ]
									    },
									    {
									        xtype: 'fieldset',
									        title: 'Escáner',
									        margin:'5px 5px 5px 5px',
									        defaults: {
									            anchor: '100%'
									        },
									        items: [
									        	{
									        		xtype:'panel',
									        		layout: 'hbox',
									        		items:[
									        			{
												            xtype: 'filefield',
												            //buttonOnly: true,
												            width: '75%',
												            anchor: '100%',
												            buttonText:'Seleccionar',
												            hideLabel: true,
												            margin:'5px 5px 5px 5px',
												            reference: 'basicFile'
												        },
										                {
											                xtype: 'checkbox',
											                boxLabel: 'Duplex',
											                margin:'5px 5px 5px 5px',
											                listeners: {
											                }
											            }
									        		]
									        	},
									            {
										            xtype: 'combobox',
										            margin:'5px 5px 5px 5px',
										            reference: 'states',
										            publishes: 'value',
										            fieldLabel: 'Modo',
										            displayField: 'state',
										            anchor: '-15',
										            store: store,
										            minChars: 0,
										            queryMode: 'local',
										            typeAhead: true
										        },
									            {
										            xtype: 'combobox',
										            margin:'5px 5px 5px 5px',
										            reference: 'states',
										            publishes: 'value',
										            fieldLabel: 'Resolución',
										            displayField: 'state',
										            anchor: '-15',
										            store: store,
										            minChars: 0,
										            queryMode: 'local',
										            typeAhead: true
										        },
										        {
													xtype: 'sliderfield',
													margin:'10px 5px 5px 5px',
													fieldLabel: 'Brillo',
													itemId: 'UpdatingSliderField',
													name: 'integer_value',
													value: [
														2
													],
													minValue: 0,
													maxValue: 100,
													listeners:{
								                        change:function(slider,value){
								                        }
								                    }
												},
												{
													xtype: 'sliderfield',
													margin:'10px 5px 5px 5px',
													fieldLabel: 'Contraste',
													itemId: 'UpdatingSliderField2',
													name: 'integer_value2',
													value: [
														2
													],
													minValue: 0,
													maxValue: 100,
													listeners:{
								                        change:function(slider,value){
								                        }
								                    }
												},


									        ]
									    },
									    {
									        xtype: 'fieldset',
									        title: 'Valores',
									        margin:'5px 5px 5px 5px',
									        defaults: {
									            anchor: '100%'
									        },
									        items: [
									    		{
										            xtype: 'filefield',
										            emptyText: 'Directorio de Destino',
										            fieldLabel: 'Destino',
										            name: 'photo-path',
										            buttonText: '',
										            buttonConfig: {
										                iconCls: 'upload-icon'
										            }
										        },
										        {
										            xtype: 'textfield',
										            fieldLabel: 'Nombre del Fichero'
										        },
										        {
										            xtype: 'combobox',
										            //margin:'5px 5px 5px 5px',
										            reference: 'states',
										            publishes: 'value',
										            fieldLabel: 'Select formato',
										            displayField: 'state',
										            anchor: '100%',
										            store: store,
										            minChars: 0,
										            queryMode: 'local',
										            typeAhead: true
										        }
										    ]
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
						                    icon: null,
						                    flex:1,
						                    glyph: 72,
						                    margin:'5px 5px 5px 5px',
						                    text: '(+)',
						                    iconAlign: 'top'
						                },
						                {
						                    xtype: 'button',
						                    icon: null,
						                    flex:1,
						                    glyph: 72,
						                    margin:'5px 5px 5px 5px',
						                    text: '(-)',
						                    iconAlign: 'top'
						                },
						                {
						                    xtype: 'button',
						                    icon: null,
						                    flex:1,
						                    glyph: 72,
						                    margin:'5px 5px 5px 5px',
						                    text: '[+]',
						                    iconAlign: 'top'
						                },
						                {
						                    xtype: 'button',
						                    icon: null,
						                    flex:1,
						                    glyph: 72,
						                    margin:'5px 5px 5px 5px',
						                    text: '[-]',
						                    iconAlign: 'top'
						                },
						                {
						                    xtype: 'button',
						                    icon: null,
						                    flex:1,
						                    glyph: 72,
						                    margin:'5px 5px 5px 5px',
						                    text: '[Rotar]',
						                    iconAlign: 'top'
						                },
						                {
						                    xtype: 'button',
						                    icon: null,
						                    flex:1,
						                    glyph: 72,
						                    margin:'5px 5px 5px 5px',
						                    text: '[Save]',
						                    iconAlign: 'top'
						                },
						                {
						                    xtype: 'button',
						                    icon: '/images/icon/batman.png',
						                    flex:1,
						                    scale: 'large',
						                    //glyph: 72,
						                    margin:'5px 5px 5px 5px',
						                    //text: '[Delete]',
						                    //iconAlign: 'top'
						                },
						                {
						                    xtype: 'button',
						                    icon: '/images/icon/if_box-open_173165.png',
						                    flex:1,
						                    //glyph: 72,
						                    scale: 'large',
						                    margin:'5px 5px 5px 5px',
						                    //height:50
						                    text: ' ',
						                    //iconAlign: 'top'
						                }
									]
								},
								{
									region:'center',
									id: scanning.id+'-panel_img',
									border:true,
									autoScroll:true,
									padding:'5px 5px 5px 5px'
								}
							]
						},
						{
							region:'east',
							border:true,
							width:'20%',
							layout:'border',
							border:true,
							padding:'5px 5px 5px 5px',
							items:[
								{
									region:'north',
									border:true,
									height:60,
									padding:'5px 5px 5px 5px',
									bodyStyle: 'background: transparent',
									layout: 'hbox',
									items:[
										{
						                    xtype: 'button',
						                    icon: null,
						                    flex:1,
						                    glyph: 72,
						                    margin:'5px 5px 5px 5px',
						                    text: 'Zoom',
						                    iconAlign: 'top'
						                },
						                {
						                    xtype: 'button',
						                    icon: null,
						                    flex:1,
						                    glyph: 72,
						                    margin:'5px 5px 5px 5px',
						                    text: 'Small',
						                    iconAlign: 'top'
						                },
						                {
						                    xtype: 'button',
						                    icon: null,
						                    flex:1,
						                    glyph: 72,
						                    margin:'5px 5px 5px 5px',
						                    text: 'Small',
						                    iconAlign: 'top'
						                },
						                {
						                    xtype: 'button',
						                    icon: null,
						                    flex:1,
						                    glyph: 72,
						                    margin:'5px 5px 5px 5px',
						                    text: 'Small',
						                    iconAlign: 'top'
						                },
						                {
						                    xtype: 'button',
						                    icon: null,
						                    flex:1,
						                    glyph: 72,
						                    margin:'5px 5px 5px 5px',
						                    text: 'Small',
						                    iconAlign: 'top'
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
											border:true,
											height:'50%',
											padding:'5px 5px 5px 5px',
											layout:'fit',
											tbar:[
												{
										            xtype: 'combobox',
										            //margin:'5px 5px 5px 5px',
										            reference: 'states',
										            publishes: 'value',
										            fieldLabel: 'Select Lote',
										            displayField: 'Lote',
										            anchor: '100%',
										            store: store,
										            minChars: 0,
										            queryMode: 'local',
										            typeAhead: true
										        }
											],
											items:[
												{
							                        xtype: 'grid',
							                        id: scanning.id + '-grid-lotizer',
							                        store: store,
							                        columnLines: true,
							                        columns:{
							                            items:[
							                                {
							                                    text: 'Lote',
							                                    dataIndex: 'lote',
							                                    width: 50
							                                },
							                                {
							                                    text: 'Paquete',
							                                    dataIndex: 'paquete',
							                                    flex: 1
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
							                                
							                            }
							                        }
							                    }
											]
										},
										{
											region:'center',
											border:true,
											padding:'5px 5px 5px 5px',
											layout:'fit',
											items:[
												{
							                        xtype: 'grid',
							                        id: scanning.id + '-grid-paginas',
							                        store: store,
							                        columnLines: true,
							                        columns:{
							                            items:[
							                                {
							                                    text: 'Lote',
							                                    dataIndex: 'lote',
							                                    width: 50
							                                },
							                                {
							                                    text: 'Paquete',
							                                    dataIndex: 'paquete',
							                                    flex: 1
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
							                                
							                            }
							                        }
							                    }
											]
										}
									]
								}
							]
						}
					]
				});
				tab.add({
					id:scanning.id+'-tab',
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
	                        global.state_item_menu(scanning.id_menu, true);
	                    },
	                    afterrender: function(obj, e){
	                        tab.setActiveTab(obj);
	                        global.state_item_menu_config(obj,scanning.id_menu);
	                        scanning.getImg_tiff('escaneado');
	                    },
	                    beforeclose:function(obj,opts){
	                    	global.state_item_menu(scanning.id_menu, false);
	                    }
					}

				}).show();
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
				win.getGalery({container:'GaleryFull',width:390,height:250,params:{forma:'F',img_path:'/scanning/'+param}});
			},
			setscanning:function(op){

				global.Msg({
                    msg: '¿Está seguro de guardar?',
                    icon: 3,
                    buttons: 3,
                    fn: function(btn){
                        Ext.getCmp(scanning.id+'-form').el.mask('Cargando…', 'x-mask-loading');

						Ext.getCmp(scanning.id+'-form-info').submit({
		                    url: scanning.url + 'setRegisterCampana/',
		                    params:{
		                        vp_op: scanning.opcion,
		                        vp_shi_codigo:scanning.cod_cam,
		                        vp_shi_nombre:Ext.getCmp(scanning.id+'-txt-nombre').getValue(),
		                        vp_shi_descripcion:Ext.getCmp(scanning.id+'-txt-descripcion').getValue(),
		                        vp_fec_ingreso:Ext.getCmp(scanning.id+'-date-re').getRawValue(),
		                        vp_estado:Ext.getCmp(scanning.id+'-cmb-estado').getValue()
		                    },
		                    success: function( fp, o ){
		                    	//console.log(o);
		                        var res = o.result;
		                        Ext.getCmp(scanning.id+'-form').el.unmask();
		                        //console.log(res);
		                        if (parseInt(res.error) == 0){
		                            global.Msg({
		                                msg: res.data,
		                                icon: 1,
		                                buttons: 1,
		                                fn: function(btn){
		                                    scanning.getReloadGridscanning('');
		                                    scanning.setNuevo();
		                                }
		                            });
		                        } else{
		                            global.Msg({
		                                msg: 'Ocurrio un error intentalo nuevamente.',
		                                icon: 0,
		                                buttons: 1,
		                                fn: function(btn){
		                                    scanning.getReloadGridscanning('');
		                                    scanning.setNuevo();
		                                }
		                            });
		                        }
		                    }
		                });
		            }
                });
			},
			getReloadGridscanning:function(name){
				Ext.getCmp(scanning.id+'-form').el.mask('Cargando…', 'x-mask-loading');
				Ext.getCmp(scanning.id + '-grid').getStore().load(
	                {params: {vp_nombre:name},
	                callback:function(){
	                	Ext.getCmp(scanning.id+'-form').el.unmask();
	                }
	            });
			},
			getReloadGridscanning:function(campana){
				Ext.getCmp(scanning.id+'-form').el.mask('Cargando…', 'x-mask-loading');
				Ext.getCmp(scanning.id + '-grid-scanning').getStore().load(
	                {params: {campana:campana},
	                callback:function(){
	                	Ext.getCmp(scanning.id+'-form').el.unmask();
	                }
	            });
			},
			setNuevo:function(){
				scanning.shi_codigo=0;
				scanning.getImagen('default.png');
				Ext.getCmp(scanning.id+'-txt-nombre').setValue('');
				Ext.getCmp(scanning.id+'-txt-descripcion').setValue('');
				Ext.getCmp(scanning.id+'-date-re').setValue('');
				Ext.getCmp(scanning.id+'-cmb-estado').setValue('');
				Ext.getCmp(scanning.id+'-txt-nombre').focus();
			},
			getImg_tiff: function(file){//(rec,recA){
				
				var panel = Ext.getCmp(scanning.id+'-panel_img');
                panel.removeAll();
                panel.add({
                    html: '<img src="/scanning/'+file+'.jpg" style="width:100%; height:"100%;" >'
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
		Ext.onReady(scanning.init,scanning);
	}else{
		tab.setActiveTab(scanning.id+'-tab');
	}
</script>