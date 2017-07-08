alias a=alias
a h=history
a x=clear
a j=jobs
a pd=pushd

alias df="df -H"
alias l="ls --color=auto"
alias lla="ls -lsahH --color=auto"
alias ll="ls -lshH --color=auto"
alias llt="ls -lshHt --color=auto"
alias llth="ls -lshHt --color=auto | head "

alias pgrep="pgrep -l"
alias du="du -h"

alias lsblk="lsblk -oname,maj:min,uuid,rm,size,ro,type,mountpoint"

alias doch='sudo $(history -p !-1)'

alias gl="git log --graph --decorate --color"
alias gls="git shortlog --graph --decorate --color"
alias dr="docker -H baerchen:4000 "
alias dc="docker -H clown:4000 "
alias gs="git status"

