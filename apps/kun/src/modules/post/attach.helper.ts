/**
 * mp3 播放器 diy
 * mp4、rmb 播放
 *
 */

const iconMap = {
  unknown:
    '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z"></path></svg>',
  gif: '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2H9v-1h3a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM3.278 13.124a1.4 1.4 0 0 0-.14-.492 1.3 1.3 0 0 0-.314-.407 1.5 1.5 0 0 0-.48-.275 1.9 1.9 0 0 0-.636-.1q-.542 0-.926.229a1.5 1.5 0 0 0-.583.632 2.1 2.1 0 0 0-.199.95v.506q0 .408.105.745.105.336.32.58.213.243.533.377.323.132.753.132.402 0 .697-.111a1.29 1.29 0 0 0 .788-.77q.097-.261.097-.551v-.797H1.717v.589h.823v.255q0 .199-.09.363a.67.67 0 0 1-.273.264 1 1 0 0 1-.457.096.87.87 0 0 1-.519-.146.9.9 0 0 1-.305-.413 1.8 1.8 0 0 1-.096-.615v-.499q0-.547.234-.85.237-.3.665-.301a1 1 0 0 1 .3.044q.136.044.236.126a.7.7 0 0 1 .17.19.8.8 0 0 1 .097.25zm1.353 2.801v-3.999H3.84v4h.79Zm1.493-1.59v1.59h-.791v-3.999H7.88v.653H6.124v1.117h1.605v.638z"></path></svg>',
  jpeg: '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zm-4.34 8.132q.114.23.14.492h-.776a.8.8 0 0 0-.097-.249.7.7 0 0 0-.17-.19.7.7 0 0 0-.237-.126 1 1 0 0 0-.299-.044q-.428 0-.665.302-.234.301-.234.85v.498q0 .351.097.615a.9.9 0 0 0 .304.413.87.87 0 0 0 .519.146 1 1 0 0 0 .457-.096.67.67 0 0 0 .272-.264q.09-.164.091-.363v-.255H8.24v-.59h1.576v.798q0 .29-.097.55a1.3 1.3 0 0 1-.293.458 1.4 1.4 0 0 1-.495.313q-.296.111-.697.111a2 2 0 0 1-.753-.132 1.45 1.45 0 0 1-.533-.377 1.6 1.6 0 0 1-.32-.58 2.5 2.5 0 0 1-.105-.745v-.506q0-.543.2-.95.201-.406.582-.633.384-.228.926-.228.357 0 .636.1.28.1.48.275t.314.407ZM0 14.786q0 .246.082.465.083.22.243.39.165.17.407.267.246.093.569.093.63 0 .984-.345.357-.346.358-1.005v-2.725h-.791v2.745q0 .303-.138.466t-.422.164a.5.5 0 0 1-.454-.246.6.6 0 0 1-.073-.27H0Zm4.92-2.86H3.322v4h.791v-1.343h.803q.43 0 .732-.172.305-.177.463-.475.162-.302.161-.677 0-.374-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179Zm.546 1.333a.8.8 0 0 1-.085.381.57.57 0 0 1-.238.24.8.8 0 0 1-.375.082H4.11v-1.406h.66q.327 0 .512.182.185.181.185.521Z"></path></svg>',
  jpg: '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zm-4.34 8.132q.114.23.14.492h-.776a.8.8 0 0 0-.097-.249.7.7 0 0 0-.17-.19.7.7 0 0 0-.237-.126 1 1 0 0 0-.299-.044q-.428 0-.665.302-.234.301-.234.85v.498q0 .351.097.615a.9.9 0 0 0 .304.413.87.87 0 0 0 .519.146 1 1 0 0 0 .457-.096.67.67 0 0 0 .272-.264q.09-.164.091-.363v-.255H8.24v-.59h1.576v.798q0 .29-.097.55a1.3 1.3 0 0 1-.293.458 1.4 1.4 0 0 1-.495.313q-.296.111-.697.111a2 2 0 0 1-.753-.132 1.45 1.45 0 0 1-.533-.377 1.6 1.6 0 0 1-.32-.58 2.5 2.5 0 0 1-.105-.745v-.506q0-.543.2-.95.201-.406.582-.633.384-.228.926-.228.357 0 .636.1.28.1.48.275t.314.407ZM0 14.786q0 .246.082.465.083.22.243.39.165.17.407.267.246.093.569.093.63 0 .984-.345.357-.346.358-1.005v-2.725h-.791v2.745q0 .303-.138.466t-.422.164a.5.5 0 0 1-.454-.246.6.6 0 0 1-.073-.27H0Zm4.92-2.86H3.322v4h.791v-1.343h.803q.43 0 .732-.172.305-.177.463-.475.162-.302.161-.677 0-.374-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179Zm.546 1.333a.8.8 0 0 1-.085.381.57.57 0 0 1-.238.24.8.8 0 0 1-.375.082H4.11v-1.406h.66q.327 0 .512.182.185.181.185.521Z"></path></svg>',
  tiff: '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.928 12.512v3.337h-.794v-3.337H0v-.662h3.064v.662zm2.131-.662v3.999h-.79V11.85zm1.373 3.999v-1.59h1.606v-.64H5.432v-1.116H7.19v-.653H4.641v3.999zm2.868-1.59v1.59h-.791V11.85h2.548v.653H8.3v1.117h1.605v.638z"></path></svg>',
  svg: '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2v-1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM0 14.841a1.13 1.13 0 0 0 .401.823q.194.162.478.252.285.091.665.091.507 0 .858-.158.355-.158.54-.44a1.17 1.17 0 0 0 .187-.656q0-.336-.135-.56a1 1 0 0 0-.375-.357 2 2 0 0 0-.565-.21l-.621-.144a1 1 0 0 1-.405-.176.37.37 0 0 1-.143-.299q0-.234.184-.384.187-.152.513-.152.214 0 .37.068a.6.6 0 0 1 .245.181.56.56 0 0 1 .12.258h.75a1.1 1.1 0 0 0-.199-.566 1.2 1.2 0 0 0-.5-.41 1.8 1.8 0 0 0-.78-.152q-.44 0-.776.15-.337.149-.528.421-.19.273-.19.639 0 .302.123.524t.351.367q.229.143.54.213l.618.144q.31.073.462.193a.39.39 0 0 1 .153.326.5.5 0 0 1-.085.29.56.56 0 0 1-.256.193q-.167.07-.413.07-.176 0-.32-.04a.8.8 0 0 1-.248-.115.58.58 0 0 1-.255-.384zm4.575 1.09h.952l1.327-3.999h-.879l-.887 3.138H5.05l-.897-3.138h-.917zm5.483-3.293q.114.228.14.492h-.776a.8.8 0 0 0-.096-.249.7.7 0 0 0-.17-.19.7.7 0 0 0-.237-.126 1 1 0 0 0-.3-.044q-.427 0-.664.302-.235.3-.235.85v.497q0 .352.097.616a.9.9 0 0 0 .305.413.87.87 0 0 0 .518.146 1 1 0 0 0 .457-.097.67.67 0 0 0 .273-.263q.09-.164.09-.364v-.254h-.823v-.59h1.576v.798q0 .29-.096.55a1.3 1.3 0 0 1-.293.457 1.4 1.4 0 0 1-.495.314q-.296.111-.698.111a2 2 0 0 1-.752-.132 1.45 1.45 0 0 1-.534-.377 1.6 1.6 0 0 1-.319-.58 2.5 2.5 0 0 1-.105-.745v-.507q0-.54.199-.949.202-.406.583-.633.383-.228.926-.228.357 0 .635.1.282.1.48.275.2.176.314.407"></path></svg>',
  bmp: '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2v-1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM0 15.849h1.664q.408 0 .72-.132.315-.135.493-.386.18-.253.179-.61a1 1 0 0 0-.123-.51.85.85 0 0 0-.323-.325 1.1 1.1 0 0 0-.445-.14v-.036a1 1 0 0 0 .352-.16.8.8 0 0 0 .243-.294.9.9 0 0 0 .09-.422q0-.463-.322-.723-.322-.261-.858-.261H0zm.785-3.404h.7q.28 0 .431.14.155.138.155.384a.5.5 0 0 1-.082.296.5.5 0 0 1-.249.185 1.2 1.2 0 0 1-.433.064H.785zm0 1.62h.75q.231 0 .393.073a.5.5 0 0 1 .24.211.6.6 0 0 1 .082.325q0 .284-.205.434-.205.146-.671.146H.785zm3.474 1.784v-2.66h.038l.952 2.16h.515l.947-2.16h.038v2.66h.715V11.85h-.8l-1.14 2.596h-.026l-1.14-2.596h-.805v3.999zm3.918-3.999h1.6q.434 0 .732.179.302.176.46.477.159.302.159.677t-.162.677q-.158.299-.462.474a1.45 1.45 0 0 1-.733.173h-.803v1.342h-.79zm2.06 1.714a.8.8 0 0 0 .085-.381q0-.34-.185-.521-.185-.182-.512-.182h-.66v1.406h.66a.8.8 0 0 0 .375-.082.57.57 0 0 0 .237-.24"></path></svg>',
  webp: '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M8.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"></path><path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v8l-2.083-2.083a.5.5 0 0 0-.76.063L8 11 5.835 9.7a.5.5 0 0 0-.611.076L3 12z"></path></svg>',
  avif: '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M8.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"></path><path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v8l-2.083-2.083a.5.5 0 0 0-.76.063L8 11 5.835 9.7a.5.5 0 0 0-.611.076L3 12z"></path></svg>',
  mp3: '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2v-1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zm-4.911 9.67h-.443v-.609h.422a.7.7 0 0 0 .322-.073.56.56 0 0 0 .22-.2.5.5 0 0 0 .076-.284.49.49 0 0 0-.176-.392.65.65 0 0 0-.442-.15.7.7 0 0 0-.252.041.6.6 0 0 0-.193.112.5.5 0 0 0-.179.349H7.71q.009-.235.102-.437.094-.202.27-.352.176-.152.428-.237.255-.085.583-.088.418-.003.723.132.304.135.472.372a.9.9 0 0 1 .173.539.83.83 0 0 1-.12.478.96.96 0 0 1-.619.439v.041a1 1 0 0 1 .718.434.9.9 0 0 1 .144.521q.003.285-.117.507a1.1 1.1 0 0 1-.329.378q-.21.152-.486.234-.273.08-.583.08-.451 0-.77-.153a1.2 1.2 0 0 1-.487-.41 1.1 1.1 0 0 1-.178-.563h.726a.46.46 0 0 0 .106.258.7.7 0 0 0 .249.179 1 1 0 0 0 .357.067.9.9 0 0 0 .384-.076.6.6 0 0 0 .252-.217.56.56 0 0 0 .088-.319.56.56 0 0 0-.334-.522.8.8 0 0 0-.372-.079ZM.706 15.925v-2.66h.038l.952 2.16h.516l.946-2.16h.038v2.66h.715v-3.999h-.8l-1.14 2.596h-.026l-1.14-2.596H0v4zm5.458-3.999h-1.6v4h.792v-1.342h.803q.43 0 .732-.173.304-.177.463-.475a1.4 1.4 0 0 0 .161-.677q0-.374-.158-.677a1.2 1.2 0 0 0-.46-.477 1.4 1.4 0 0 0-.733-.179m.545 1.333a.8.8 0 0 1-.085.381.57.57 0 0 1-.237.24.8.8 0 0 1-.375.082h-.66v-1.406h.66q.328 0 .513.182.184.181.184.521"></path></svg>',
  wav: '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2v-1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.784 15.849l.741-2.789h.033l.74 2.789h.73l1.055-3.999h-.858l-.595 2.903h-.041l-.706-2.903H2.2l-.706 2.903h-.038l-.6-2.903H0l1.055 3.999zm3.715 0 .314-1.028h1.336l.313 1.028h.841L6.967 11.85h-.926L4.7 15.849h.8Zm1.002-3.234.49 1.617H5.977l.49-1.617H6.5Zm3.604 3.234h-.952L7.814 11.85h.917l.897 3.138h.038l.888-3.138h.879z"></path></svg>',
  mp4: '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2v-1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM.706 15.849v-2.66h.038l.952 2.16h.516l.946-2.16h.038v2.66h.715V11.85h-.8l-1.14 2.596h-.026L.805 11.85H0v3.999zm5.278-3.999h-1.6v3.999h.792v-1.342h.803q.43 0 .732-.173.304-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477 1.4 1.4 0 0 0-.733-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.237.241.8.8 0 0 1-.375.082h-.66V12.48h.66q.329 0 .513.181.184.183.184.522m1.505-.032q.4-.65.791-1.301h1.14v2.62h.49v.638h-.49v.741h-.741v-.741H7.287v-.648q.353-.66.747-1.31Zm-.029 1.298v.02h1.219v-2.021h-.041q-.302.477-.607.984-.3.507-.571 1.017"></path></svg>',
  mov: '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2v-1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zm-6.914 9.166v.522q0 .384-.117.641a.86.86 0 0 1-.323.387.9.9 0 0 1-.468.126.9.9 0 0 1-.472-.126.87.87 0 0 1-.32-.386 1.55 1.55 0 0 1-.117-.642v-.522q0-.386.118-.641a.87.87 0 0 1 .319-.387.87.87 0 0 1 .472-.129q.263 0 .468.13a.86.86 0 0 1 .323.386q.117.255.117.641m.802.519v-.513q0-.565-.205-.972a1.46 1.46 0 0 0-.588-.63q-.381-.22-.917-.22-.534 0-.92.22a1.44 1.44 0 0 0-.59.627q-.204.406-.204.975v.513q0 .563.205.973.205.406.589.627.386.216.92.216.536 0 .917-.216.383-.22.588-.627.205-.41.205-.973m-7.182 1.74v-2.66h.038l.952 2.16h.516l.946-2.16h.038v2.66h.715v-3.999h-.8l-1.14 2.596h-.026l-1.14-2.596H0v4zm9.54 0h-.952l-1.34-3.999h.918l.896 3.138h.038l.888-3.138h.879z"></path></svg>',
  wmv: '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M6 6.883v4.234a.5.5 0 0 0 .757.429l3.528-2.117a.5.5 0 0 0 0-.858L6.757 6.454a.5.5 0 0 0-.757.43z"></path><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"></path></svg>',
  wma: '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M6 6.883v4.234a.5.5 0 0 0 .757.429l3.528-2.117a.5.5 0 0 0 0-.858L6.757 6.454a.5.5 0 0 0-.757.43z"></path><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"></path></svg>',
  rmvb: '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M6 6.883v4.234a.5.5 0 0 0 .757.429l3.528-2.117a.5.5 0 0 0 0-.858L6.757 6.454a.5.5 0 0 0-.757.43z"></path><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"></path></svg>',
  rm: '<svg  class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M6 6.883v4.234a.5.5 0 0 0 .757.429l3.528-2.117a.5.5 0 0 0 0-.858L6.757 6.454a.5.5 0 0 0-.757.43z"></path><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"></path></svg>',
  avi: '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M6 6.883v4.234a.5.5 0 0 0 .757.429l3.528-2.117a.5.5 0 0 0 0-.858L6.757 6.454a.5.5 0 0 0-.757.43z"></path><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"></path></svg>',
  flv: '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M6 6.883v4.234a.5.5 0 0 0 .757.429l3.528-2.117a.5.5 0 0 0 0-.858L6.757 6.454a.5.5 0 0 0-.757.43z"></path><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"></path></svg>',
  ogg: '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M6 6.883v4.234a.5.5 0 0 0 .757.429l3.528-2.117a.5.5 0 0 0 0-.858L6.757 6.454a.5.5 0 0 0-.757.43z"></path><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"></path></svg>',
  oga: '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M6 6.883v4.234a.5.5 0 0 0 .757.429l3.528-2.117a.5.5 0 0 0 0-.858L6.757 6.454a.5.5 0 0 0-.757.43z"></path><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"></path></svg>',
  ogv: '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M6 6.883v4.234a.5.5 0 0 0 .757.429l3.528-2.117a.5.5 0 0 0 0-.858L6.757 6.454a.5.5 0 0 0-.757.43z"></path><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"></path></svg>',
  txt: '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-2v-1h2a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.928 15.849v-3.337h1.136v-.662H0v.662h1.134v3.337zm4.689-3.999h-.894L4.9 13.289h-.035l-.832-1.439h-.932l1.228 1.983-1.24 2.016h.862l.853-1.415h.035l.85 1.415h.907l-1.253-1.992zm1.93.662v3.337h-.794v-3.337H6.619v-.662h3.064v.662H8.546Z"></path></svg>',
  doc: '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2v-1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zm-7.839 9.166v.522q0 .384-.117.641a.86.86 0 0 1-.322.387.9.9 0 0 1-.469.126.9.9 0 0 1-.471-.126.87.87 0 0 1-.32-.386 1.55 1.55 0 0 1-.117-.642v-.522q0-.386.117-.641a.87.87 0 0 1 .32-.387.87.87 0 0 1 .471-.129q.264 0 .469.13a.86.86 0 0 1 .322.386q.117.255.117.641m.803.519v-.513q0-.565-.205-.972a1.46 1.46 0 0 0-.589-.63q-.381-.22-.917-.22-.533 0-.92.22a1.44 1.44 0 0 0-.589.627q-.204.406-.205.975v.513q0 .563.205.973.205.406.59.627.386.216.92.216.535 0 .916-.216.383-.22.59-.627.204-.41.204-.973M0 11.926v4h1.459q.603 0 .999-.238a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.59-.68q-.395-.234-1.004-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082H.79V12.57Zm7.422.483a1.7 1.7 0 0 0-.103.633v.495q0 .369.103.627a.83.83 0 0 0 .298.393.85.85 0 0 0 .478.131.9.9 0 0 0 .401-.088.7.7 0 0 0 .273-.248.8.8 0 0 0 .117-.364h.765v.076a1.27 1.27 0 0 1-.226.674q-.205.29-.55.454a1.8 1.8 0 0 1-.786.164q-.54 0-.914-.216a1.4 1.4 0 0 1-.571-.627q-.194-.408-.194-.976v-.498q0-.568.197-.978.195-.411.571-.633.378-.223.911-.223.328 0 .607.097.28.093.489.272a1.33 1.33 0 0 1 .466.964v.073H9.78a.85.85 0 0 0-.12-.38.7.7 0 0 0-.273-.261.8.8 0 0 0-.398-.097.8.8 0 0 0-.475.138.87.87 0 0 0-.301.398"></path></svg>',
  docx: '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V11h-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zm-6.839 9.688v-.522a1.5 1.5 0 0 0-.117-.641.86.86 0 0 0-.322-.387.86.86 0 0 0-.469-.129.87.87 0 0 0-.471.13.87.87 0 0 0-.32.386 1.5 1.5 0 0 0-.117.641v.522q0 .384.117.641a.87.87 0 0 0 .32.387.9.9 0 0 0 .471.126.9.9 0 0 0 .469-.126.86.86 0 0 0 .322-.386 1.55 1.55 0 0 0 .117-.642m.803-.516v.513q0 .563-.205.973a1.47 1.47 0 0 1-.589.627q-.381.216-.917.216a1.86 1.86 0 0 1-.92-.216 1.46 1.46 0 0 1-.589-.627 2.15 2.15 0 0 1-.205-.973v-.513q0-.569.205-.975.205-.411.59-.627.386-.22.92-.22.535 0 .916.22.383.219.59.63.204.406.204.972M1 15.925v-3.999h1.459q.609 0 1.005.235.396.233.589.68.196.445.196 1.074 0 .634-.196 1.084-.197.451-.595.689-.396.237-.999.237zm1.354-3.354H1.79v2.707h.563q.277 0 .483-.082a.8.8 0 0 0 .334-.252q.132-.17.196-.422a2.3 2.3 0 0 0 .068-.592q0-.45-.118-.753a.9.9 0 0 0-.354-.454q-.237-.152-.61-.152Zm6.756 1.116q0-.373.103-.633a.87.87 0 0 1 .301-.398.8.8 0 0 1 .475-.138q.225 0 .398.097a.7.7 0 0 1 .273.26.85.85 0 0 1 .12.381h.765v-.073a1.33 1.33 0 0 0-.466-.964 1.4 1.4 0 0 0-.49-.272 1.8 1.8 0 0 0-.606-.097q-.534 0-.911.223-.375.222-.571.633-.197.41-.197.978v.498q0 .568.194.976.195.406.571.627.375.216.914.216.44 0 .785-.164t.551-.454a1.27 1.27 0 0 0 .226-.674v-.076h-.765a.8.8 0 0 1-.117.364.7.7 0 0 1-.273.248.9.9 0 0 1-.401.088.85.85 0 0 1-.478-.131.83.83 0 0 1-.298-.393 1.7 1.7 0 0 1-.103-.627zm5.092-1.76h.894l-1.275 2.006 1.254 1.992h-.908l-.85-1.415h-.035l-.852 1.415h-.862l1.24-2.015-1.228-1.984h.932l.832 1.439h.035z"></path></svg>',
  xls: '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM6.472 15.29a1.2 1.2 0 0 1-.111-.449h.765a.58.58 0 0 0 .254.384q.106.073.25.114.143.041.319.041.246 0 .413-.07a.56.56 0 0 0 .255-.193.5.5 0 0 0 .085-.29.39.39 0 0 0-.153-.326q-.152-.12-.462-.193l-.619-.143a1.7 1.7 0 0 1-.539-.214 1 1 0 0 1-.351-.367 1.1 1.1 0 0 1-.123-.524q0-.366.19-.639.19-.272.527-.422.338-.15.777-.149.457 0 .78.152.324.153.5.41.18.255.2.566h-.75a.56.56 0 0 0-.12-.258.6.6 0 0 0-.247-.181.9.9 0 0 0-.369-.068q-.325 0-.513.152a.47.47 0 0 0-.184.384q0 .18.143.3a1 1 0 0 0 .405.175l.62.143q.326.075.566.211a1 1 0 0 1 .375.358q.135.222.135.56 0 .37-.188.656a1.2 1.2 0 0 1-.539.439q-.351.158-.858.158-.381 0-.665-.09a1.4 1.4 0 0 1-.478-.252 1.1 1.1 0 0 1-.29-.375m-2.945-3.358h-.893L1.81 13.37h-.036l-.832-1.438h-.93l1.227 1.983L0 15.931h.861l.853-1.415h.035l.85 1.415h.908L2.253 13.94zm2.727 3.325H4.557v-3.325h-.79v4h2.487z"></path></svg>',
  xlsx: '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V11h-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM7.86 14.841a1.13 1.13 0 0 0 .401.823q.195.162.479.252.284.091.665.091.507 0 .858-.158.355-.158.54-.44a1.17 1.17 0 0 0 .187-.656q0-.336-.135-.56a1 1 0 0 0-.375-.357 2 2 0 0 0-.565-.21l-.621-.144a1 1 0 0 1-.405-.176.37.37 0 0 1-.143-.299q0-.234.184-.384.188-.152.513-.152.214 0 .37.068a.6.6 0 0 1 .245.181.56.56 0 0 1 .12.258h.75a1.1 1.1 0 0 0-.199-.566 1.2 1.2 0 0 0-.5-.41 1.8 1.8 0 0 0-.78-.152q-.44 0-.777.15-.336.149-.527.421-.19.273-.19.639 0 .302.123.524t.351.367q.229.143.54.213l.618.144q.31.073.462.193a.39.39 0 0 1 .153.326.5.5 0 0 1-.085.29.56.56 0 0 1-.255.193q-.168.07-.413.07-.176 0-.32-.04a.8.8 0 0 1-.249-.115.58.58 0 0 1-.255-.384zm-3.726-2.909h.893l-1.274 2.007 1.254 1.992h-.908l-.85-1.415h-.035l-.853 1.415H1.5l1.24-2.016-1.228-1.983h.931l.832 1.438h.036zm1.923 3.325h1.697v.674H5.266v-3.999h.791zm7.636-3.325h.893l-1.274 2.007 1.254 1.992h-.908l-.85-1.415h-.035l-.853 1.415h-.861l1.24-2.016-1.228-1.983h.931l.832 1.438h.036z"></path></svg>',
  ppt: '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m2.817-1.333h-1.6v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474.162-.302.161-.677 0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H4.15V12.48h.66q.327 0 .512.181.185.183.185.522m2.767-.67v3.336H7.48v-3.337H6.346v-.662h3.065v.662z"></path></svg>',
  pptx: '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V11h-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.5 11.85h1.6q.434 0 .732.179.302.175.46.477t.158.677-.16.677q-.159.299-.464.474a1.45 1.45 0 0 1-.732.173H2.29v1.342H1.5zm2.06 1.714a.8.8 0 0 0 .085-.381q0-.34-.185-.521-.185-.182-.513-.182h-.659v1.406h.66a.8.8 0 0 0 .374-.082.57.57 0 0 0 .238-.24m1.302-1.714h1.6q.434 0 .732.179.302.175.46.477t.158.677-.16.677q-.158.299-.464.474a1.45 1.45 0 0 1-.732.173h-.803v1.342h-.79zm2.06 1.714a.8.8 0 0 0 .085-.381q0-.34-.185-.521-.184-.182-.513-.182H5.65v1.406h.66a.8.8 0 0 0 .374-.082.57.57 0 0 0 .238-.24m2.852 2.285v-3.337h1.137v-.662H7.846v.662H8.98v3.337zm3.796-3.999h.893l-1.274 2.007 1.254 1.992h-.908l-.85-1.415h-.035l-.853 1.415h-.861l1.24-2.016-1.228-1.983h.931l.832 1.439h.035z"></path></svg>',
  zip: '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M6.5 7.5a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v.938l.4 1.599a1 1 0 0 1-.416 1.074l-.93.62a1 1 0 0 1-1.109 0l-.93-.62a1 1 0 0 1-.415-1.074l.4-1.599zm2 0h-1v.938a1 1 0 0 1-.03.243l-.4 1.598.93.62.93-.62-.4-1.598a1 1 0 0 1-.03-.243z"></path><path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm5.5-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9v1H8v1h1v1H8v1h1v1H7.5V5h-1V4h1V3h-1V2h1z"></path></svg>',
  rar: '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M6.5 7.5a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v.938l.4 1.599a1 1 0 0 1-.416 1.074l-.93.62a1 1 0 0 1-1.109 0l-.93-.62a1 1 0 0 1-.415-1.074l.4-1.599zm2 0h-1v.938a1 1 0 0 1-.03.243l-.4 1.598.93.62.93-.62-.4-1.598a1 1 0 0 1-.03-.243z"></path><path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm5.5-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9v1H8v1h1v1H8v1h1v1H7.5V5h-1V4h1V3h-1V2h1z"></path></svg>',
  pdf: '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"></path><path d="M4.603 14.087a.8.8 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.7 7.7 0 0 1 1.482-.645 20 20 0 0 0 1.062-2.227 7.3 7.3 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a11 11 0 0 0 .98 1.686 5.8 5.8 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.86.86 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.7 5.7 0 0 1-.911-.95 11.7 11.7 0 0 0-1.997.406 11.3 11.3 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.8.8 0 0 1-.58.029m1.379-1.901q-.25.115-.459.238c-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361q.016.032.026.044l.035-.012c.137-.056.355-.235.635-.572a8 8 0 0 0 .45-.606m1.64-1.33a13 13 0 0 1 1.01-.193 12 12 0 0 1-.51-.858 21 21 0 0 1-.5 1.05zm2.446.45q.226.245.435.41c.24.19.407.253.498.256a.1.1 0 0 0 .07-.015.3.3 0 0 0 .094-.125.44.44 0 0 0 .059-.2.1.1 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a4 4 0 0 0-.612-.053zM8.078 7.8a7 7 0 0 0 .2-.828q.046-.282.038-.465a.6.6 0 0 0-.032-.198.5.5 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822q.036.167.09.346z"></path></svg>',
} as Record<any, any>;

const downloadIcon = `<svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>`;
const playIcon = `<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M6 4v16a1 1 0 0 0 1.524 .852l13 -8a1 1 0 0 0 0 -1.704l-13 -8a1 1 0 0 0 -1.524 .852z"></path></svg>`;
const pauseIcon = `<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M17 4h-10a3 3 0 0 0 -3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3 -3v-10a3 3 0 0 0 -3 -3z"></path></svg>`;
const audioIcon = `<svg class="mr-2 inline-block" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8.5 2a.5.5 0 0 1 .5.5v11a.5.5 0 0 1-1 0v-11a.5.5 0 0 1 .5-.5m-2 2a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5m4 0a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5m-6 1.5A.5.5 0 0 1 5 6v4a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m8 0a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m-10 1A.5.5 0 0 1 3 7v2a.5.5 0 0 1-1 0V7a.5.5 0 0 1 .5-.5m12 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0V7a.5.5 0 0 1 .5-.5"></path></svg>`;

export const useAttachHelper = () => {
  const extensions = Object.keys(iconMap);
  const selector = extensions
    .map((ext) => `.markdown-body a[href$=".${ext}"]`)
    .join(", ");
  const links = document.querySelectorAll(
    selector
  ) as NodeListOf<HTMLAnchorElement>;
  links.forEach((link) => {
    const pathname = new URL(link.href).pathname;
    const match = pathname.match(/\.([0-9a-z]+)(?:[\?#]|$)/i);
    const ext = match ? match[1] : "unknown";
    const svg = iconMap[ext];
    const text =
      link.getAttribute("title") ??
      link.getAttribute("alt") ??
      link.textContent ??
      "";
    const parent = link.parentNode;
    if (["img", "pdf", "jpeg", "png", "jpg", "txt"].includes(ext)) {
      const newLink = createLink(svg, text, link.href, downloadIcon);
      parent?.appendChild(newLink);
    } else if (["mp4"].includes(ext)) {
      const video = createVideoPlayerElement(link.href);
      parent?.appendChild(video);
    } else if (["mp3", "wav"].includes(ext)) {
      const audio = createAudioPlayerElement(link.href, text);
      parent?.appendChild(audio);
    }
    parent?.removeChild(link);
  });
};

// 创建并返回一个自定义元素
const createLink = (
  svg: string,
  text: string,
  linkHref: string,
  downloadIcon: string
): HTMLElement => {
  // 创建容器
  const container = document.createElement("a");
  container.setAttribute("href", linkHref);
  container.setAttribute("target", "_blank");
  container.setAttribute("download", "");
  container.style.textDecoration = "none";

  const div = document.createElement("div");
  div.className =
    "flex underline-none items-start my-2.5 hvr-forward bg-gray-100 dark:bg-zinc-800 cursor-pointer py-2 px-4 rounded-tl-lg rounded-tr-2xl rounded-br-2xl rounded-bl-2xl";
  container.appendChild(div);

  // 创建 flex-1 容器
  const flexContainer = document.createElement("div");
  flexContainer.className = "flex-1 truncate";
  div.appendChild(flexContainer);

  // 创建内部 flex 容器
  const innerFlexContainer = document.createElement("div");
  innerFlexContainer.className =
    "flex items-center gap-2 text-sm text-zinc-700 dark:text-white";
  innerFlexContainer.innerHTML = `${svg}<div class="flex-grow pr-4 truncate">${text}</div>`;
  flexContainer.appendChild(innerFlexContainer);

  // 创建链接元素
  const linkElement = document.createElement("span");
  linkElement.className =
    "block text-xs font-normal truncate text-gray-500 dark:text-zinc-400 gap-2 pr-8";
  linkElement.textContent = linkHref;
  flexContainer.appendChild(linkElement);

  // 创建下载图标容器
  const downloadIconContainer = document.createElement("div");
  downloadIconContainer.className =
    "inline-flex self-center items-center text-zinc-700 dark:text-white flex-shrink-0";
  downloadIconContainer.innerHTML = downloadIcon;
  div.appendChild(downloadIconContainer);

  return container;
};

/**
 * 视频播放
 */
const createVideoPlayerElement = (videoSrc: string): HTMLElement => {
  // 创建视频元素
  const video = document.createElement("video");
  video.className =
    "w-full h-auto max-w-full border border-gray-200 rounded-lg dark:border-gray-700";
  video.muted = true;
  video.autoplay = true;
  video.controls = true;

  // 创建 source 元素
  const source = document.createElement("source");
  source.src = videoSrc;
  source.type = "video/mp4";
  video.appendChild(source);

  // 创建不支持视频标签时的提示
  const fallbackText = document.createTextNode(
    "Your browser does not support the video tag."
  );
  video.appendChild(fallbackText);

  return video;
};

/**
 * 创建音频播放器
 */
const createAudioPlayerElement = (
  audioSrc: string,
  title: string
): HTMLDivElement => {
  // 创建容器
  const container = document.createElement("div");
  container.className =
    "relative my-2.5 bg-gray-100 dark:bg-zinc-800 py-2 px-4 rounded-tl-lg rounded-tr-2xl rounded-br-2xl rounded-bl-2xl";
  container.setAttribute("data-player", "audioPlayer");

  // 创建标题容器
  const titleContainer = document.createElement("div");
  titleContainer.className = "flex items-center justify-between pb-1";
  container.appendChild(titleContainer);

  // 歌曲标题
  const div = document.createElement("div");
  div.className = "truncate flex-1 pr-8 items-center";
  div.innerHTML = `${audioIcon}<span class="align-middle">${title}</span>`;
  titleContainer.appendChild(div);

  // 创建播放按钮
  const playButton = document.createElement("button");
  playButton.className =
    "bg-zinc-200 text-zinc-600 hover:bg-blue-500 hover:text-white p-1.5 rounded-full cursor-pointer dark:bg-zinc-700 dark:text-white hover:dark:bg-blue-500 hover:dark:text-white";
  playButton.innerHTML = playIcon;
  titleContainer.appendChild(playButton);

  // 创建进度条容器
  const progressContainer = document.createElement("div");
  progressContainer.style.lineHeight = "1";
  container.appendChild(progressContainer);

  // 创建进度条
  const progressBar = document.createElement("input");
  progressBar.type = "range";
  progressBar.className =
    "w-full h-1 bg-zinc-200 rounded-full appearance-none cursor-pointer dark:bg-zinc-700 range-sm";
  progressBar.value = "0"; // 初始进度为0
  progressContainer.appendChild(progressBar);

  // 创建播放时间容器
  const timeContainer = document.createElement("div");
  timeContainer.className =
    "flex justify-between text-zinc-500 dark:text-zinc-300 text-xs";
  progressContainer.appendChild(timeContainer);

  // 创建当前时间显示
  const currentTime = document.createElement("span");
  currentTime.textContent = "00:00";
  timeContainer.appendChild(currentTime);

  // 创建总时间显示
  const totalTime = document.createElement("span");
  totalTime.textContent = "00:00"; // 初始总时间
  timeContainer.appendChild(totalTime);

  // 创建音频元素
  const audio = document.createElement("audio");
  audio.className = "hidden";
  const source = document.createElement("source");
  source.src = audioSrc;
  source.type = "audio/mpeg";
  audio.appendChild(source);
  container.appendChild(audio);

  // 标记变量，用于检测是否因拖动而暂停
  let wasPlaying = false;
  let firstDrag = true; // 标记是否是第一次拖动

  // 鼠标按下时处理
  progressBar.addEventListener("mousedown", () => {
    if (!audio.paused) {
      audio.pause();
      wasPlaying = true; // 记录音频是暂停前正在播放
    }
  });

  // 鼠标放开时处理
  progressBar.addEventListener("mouseup", () => {
    if (wasPlaying || firstDrag) {
      audio.play();
      wasPlaying = false; // 重置标记
      firstDrag = false; // 第一次拖动结束后将标记设置为false
      playButton.innerHTML = pauseIcon;
    }
  });

  // 同步进度条拖动和音频播放
  progressBar.addEventListener("input", () => {
    const seekTime = (progressBar.valueAsNumber / 100) * audio.duration;
    audio.currentTime = seekTime;
    // 如果是第一次拖动，不自动播放
    if (firstDrag) {
      audio.pause();
    }
  });

  // 注册播放按钮点击事件
  playButton.addEventListener("click", () => {
    // 控制当前播放器
    if (audio.paused) {
      audio.play();
      playButton.innerHTML = pauseIcon;
      // 暂停其他所有播放器
      const allPlayers = document.querySelectorAll(
        "[data-player='audioPlayer']"
      );
      allPlayers.forEach((player) => {
        const otherAudio = player.querySelector("audio") as HTMLAudioElement;
        const otherPlayButton = player.querySelector(
          "button"
        ) as HTMLButtonElement;
        if (otherAudio !== audio && !otherAudio.paused) {
          otherAudio.pause();
          otherPlayButton.innerHTML = playIcon;
        }
      });
    } else {
      audio.pause();
      playButton.innerHTML = playIcon;
    }
  });

  // 音频加载完成后更新总时间
  audio.addEventListener("loadedmetadata", () => {
    totalTime.textContent = new Date(audio.duration * 1000)
      .toISOString()
      .substr(14, 5);
  });

  // 更新进度条和时间显示
  audio.addEventListener("timeupdate", () => {
    const percent = (audio.currentTime / audio.duration) * 100;
    progressBar.value = percent.toString();
    currentTime.textContent = new Date(audio.currentTime * 1000)
      .toISOString()
      .substr(14, 5);
  });

  // 播放结束时重置播放按钮
  audio.addEventListener("ended", () => {
    playButton.innerHTML = playIcon;
    progressBar.value = "0";
    currentTime.textContent = "00:00";
    firstDrag = true; // 重置第一次拖动标记
  });

  return container;
};
