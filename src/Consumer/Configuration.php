<?php

declare(strict_types=1);

namespace Basis\Nats\Consumer;

class Configuration
{
    private ?bool $flowControl = null;
    private ?bool $headersOnly = null;
    private ?int $ackWait = null;
    private ?int $idleHeartbeat = null;
    private ?int $maxAckPending = null;
    private ?int $maxDeliver = null;
    private ?int $maxWaiting = null;
    private ?int $optStartSeq = null;
    private ?int $optStartTime = null;
    private ?string $deliverGroup = null;
    private ?string $deliverSubject = null;
    private ?string $description = null;
    private ?string $subjectFilter = null;
    private string $ackPolicy = AckPolicy::EXPLICIT;
    private string $deliverPolicy = DeliverPolicy::ALL;
    private string $replayPolicy = ReplayPolicy::INSTANT;
    private string $stream;
    private string $name;

    public function __construct(string $stream, string $name) {
        $this->stream = $stream;
        $this->name = $name;
    }

    public function getAckPolicy(): string
    {
        return $this->ackPolicy;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStream(): string
    {
        return $this->stream;
    }

    public function getSubjectFilter(): ?string
    {
        return $this->subjectFilter;
    }

    public function getAckWait()
    {
        return $this->ackWait;
    }

    public function getDeliverGroup()
    {
        return $this->deliverGroup;
    }

    public function getDeliverPolicy()
    {
        return $this->deliverPolicy;
    }

    public function getDeliverSubject()
    {
        return $this->deliverSubject;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getFlowControl()
    {
        return $this->flowControl;
    }

    public function getHeadersOnly()
    {
        return $this->headersOnly;
    }

    public function getIdleHeartbeat()
    {
        return $this->idleHeartbeat;
    }

    public function getMaxAckPending()
    {
        return $this->maxAckPending;
    }

    public function getMaxDeliver()
    {
        return $this->maxDeliver;
    }

    public function getMaxWaiting()
    {
        return $this->maxWaiting;
    }

    public function getOptStartSeq()
    {
        return $this->optStartSeq;
    }

    public function getOptStartTime()
    {
        return $this->optStartTime;
    }

    public function getReplayPolicy()
    {
        return $this->replayPolicy;
    }

    public function setAckPolicy(string $ackPolicy): self
    {
        $this->ackPolicy = AckPolicy::validate($ackPolicy);
        return $this;
    }

    public function setAckWait(int $ackWait): self
    {
        $this->ackWait = $ackWait;
        return $this;
    }

    public function setDeliverPolicy(string $deliverPolicy): self
    {
        $this->deliverPolicy = DeliverPolicy::validate($deliverPolicy);
        return $this;
    }

    public function setMaxAckPending(int $maxAckPending): self
    {
        $this->maxAckPending = $maxAckPending;
        return $this;
    }

    public function setReplayPolicy(string $replayPolicy): self
    {
        $this->replayPolicy = ReplayPolicy::validate($replayPolicy);
        return $this;
    }

    public function setSubjectFilter(string $subjectFilter): self
    {
        $this->subjectFilter = $subjectFilter;
        return $this;
    }

    public function toArray(): array
    {
        $config = [
            'ack_policy' => $this->getAckPolicy(),
            'ack_wait' => $this->getAckWait(),
            'deliver_group' => $this->getDeliverGroup(),
            'deliver_policy' => $this->getDeliverPolicy(),
            'deliver_subject' => $this->getDeliverSubject(),
            'description' => $this->getDescription(),
            'durable_name' => $this->getName(),
            'flow_control' => $this->getFlowControl(),
            'headers_only' => $this->getHeadersOnly(),
            'idle_heartbeat' => $this->getIdleHeartbeat(),
            'max_ack_pending' => $this->getMaxAckPending(),
            'max_deliver' => $this->getMaxDeliver(),
            'max_waiting' => $this->getMaxWaiting(),
            'replay_policy' => $this->getReplayPolicy(),
        ];

        switch ($this->getDeliverPolicy()) {
            case DeliverPolicy::BY_START_SEQUENCE:
                $config['opt_start_seq'] = $this->getOptStartSeq();
                break;

            case DeliverPolicy::BY_START_TIME:
                $config['opt_start_time'] = $this->getOptStartTime();
                break;
        }

        if ($this->getSubjectFilter()) {
            $config['filter_subject'] = $this->getSubjectFilter();
        }

        foreach ($config as $k => $v) {
            if ($v === null) {
                unset($config[$k]);
            }
        }

        return [
            'stream_name' => $this->getStream(),
            'config' => $config,
        ];
    }
}
